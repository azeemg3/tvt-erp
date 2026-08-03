<?php

namespace App\Http\Controllers\Reports\Ledger;

use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reports\ParsesReportDates;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Ledger Report Format 1 — combined ledger activity in one register.
 *
 * Sections: Invoices (all sale modes), Refunds, Cash & Bank Receipts, Cash Payments,
 * period debit/credit totals, and a detailed balance summary.
 */
class LedgerReportFormat1Controller extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Ledger.ledger_report_format_1.index');
    }

    public function get_data(Request $request)
    {
        $request->validate([
            'ledger_id' => 'required|integer',
        ]);

        try {
            [$df, $dt] = $this->parseReportDateRange($request);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $ledgerId = (int) $request->ledger_id;

        $ledger = TransactionAccount::find($ledgerId);
        if (!$ledger) {
            return response()->json(['message' => 'Ledger account not found.'], 422);
        }

        $openingBalance = Account::ob($df, $ledgerId);
        $invoiceLines = $this->collectInvoiceLines($ledgerId, $df, $dt);
        $refundLines = $this->collectRefundLines($ledgerId, $df, $dt);
        $receiptLines = $this->collectReceiptLines($ledgerId, $df, $dt);
        $paymentLines = $this->collectPaymentLines($ledgerId, $df, $dt);

        $invoiceDebit = collect($invoiceLines)->sum('debit');
        $refundCredit = collect($refundLines)->sum('credit');
        $receiptCredit = collect($receiptLines)->sum('credit');
        $paymentCredit = collect($paymentLines)->sum('credit');

        $periodDebit = $invoiceDebit;
        $periodCredit = $refundCredit + $receiptCredit + $paymentCredit;
        $closingBalance = $openingBalance + $periodDebit - $periodCredit;

        $invoiceTotalsByType = $this->invoiceTotalsBySaleType($ledgerId, $df, $dt);
        $refundTotalsByType = $this->refundTotalsBySaleType($ledgerId, $df, $dt);

        return response()->json([
            'ledger_name' => $ledger->Trans_Acc_Name,
            'report_title' => 'Ledger Report Format 1',
            'invoices' => $invoiceLines,
            'invoice_section_total' => round($invoiceDebit, 2),
            'refunds' => $refundLines,
            'refund_section_total' => round($refundCredit, 2),
            'receipts' => $receiptLines,
            'receipt_section_total' => round($receiptCredit, 2),
            'payments' => $paymentLines,
            'payment_section_total' => round($paymentCredit, 2),
            'period_total_debit' => round($periodDebit, 2),
            'period_total_credit' => round($periodCredit, 2),
            'summary' => [
                'opening_balance_label' => Account::show_bal($openingBalance),
                'ticket_invoices' => $invoiceTotalsByType['ticket'],
                'hotel_invoices' => $invoiceTotalsByType['hotel'],
                'visa_invoices' => $invoiceTotalsByType['visa'],
                'transfer_invoices' => $invoiceTotalsByType['transfer'],
                'other_invoices' => $invoiceTotalsByType['other'],
                'invoices_total' => round($invoiceDebit, 2),
                'invoices_total_label' => Account::show_bal($invoiceDebit),
                'ticket_refunds' => $refundTotalsByType['ticket'],
                'hotel_refunds' => $refundTotalsByType['hotel'],
                'visa_refunds' => $refundTotalsByType['visa'],
                'transfer_refunds' => $refundTotalsByType['transfer'],
                'other_refunds' => $refundTotalsByType['other'],
                'refunds_total' => round($refundCredit, 2),
                'refunds_total_label' => Account::show_bal(-$refundCredit),
                'receipts_total' => round($receiptCredit, 2),
                'receipts_total_label' => Account::show_bal(-$receiptCredit),
                'payments_total' => round($paymentCredit, 2),
                'payments_total_label' => Account::show_bal(-$paymentCredit),
                'vouchers_total' => round($receiptCredit + $paymentCredit, 2),
                'vouchers_total_label' => Account::show_bal(-($receiptCredit + $paymentCredit)),
                'closing_balance_label' => Account::show_bal($closingBalance),
            ],
        ]);
    }

    private function collectInvoiceLines(int $ledgerId, string $df, string $dt): array
    {
        $lines = [];

        $tickets = DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->where('sale_invoices.type', 1)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.id as invoice_id',
                'tickets.ticket_no',
                'tickets.pax_name',
                'tickets.sector',
                DB::raw('COALESCE(tickets.receiveable, 0) as amount')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('tickets.id')
            ->get();

        foreach ($tickets as $row) {
            $lines[] = $this->invoiceLine('ticket', $row->voucher_date, $row->invoice_id, $row->ticket_no, $row->pax_name, $row->sector, (float) $row->amount);
        }

        $visas = DB::table('visas')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'visas.SID')
            ->leftJoin('countries', 'visas.visa_country', '=', 'countries.id')
            ->where('sale_invoices.type', 3)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.id as invoice_id',
                'visas.visa_no',
                'visas.pax_name',
                DB::raw('COALESCE(countries.name, "") as sector'),
                DB::raw('COALESCE(visas.receiveable, 0) as amount')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('visas.id')
            ->get();

        foreach ($visas as $row) {
            $lines[] = $this->invoiceLine('visa', $row->voucher_date, $row->invoice_id, $row->visa_no, $row->pax_name, $row->sector, (float) $row->amount);
        }

        $hotels = DB::table('lead_hotels')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'lead_hotels.SID')
            ->leftJoin('hotels', 'lead_hotels.hotel', '=', 'hotels.id')
            ->where('sale_invoices.type', 2)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.id as invoice_id',
                DB::raw('COALESCE(hotels.name, "") as ticket_chq_ref'),
                'lead_hotels.pax_name',
                DB::raw('CONCAT(COALESCE(lead_hotels.checkin, ""), " - ", COALESCE(lead_hotels.checkout, "")) as sector'),
                DB::raw('COALESCE(lead_hotels.receiveable, 0) as amount')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('lead_hotels.id')
            ->get();

        foreach ($hotels as $row) {
            $lines[] = $this->invoiceLine('hotel', $row->voucher_date, $row->invoice_id, $row->ticket_chq_ref, $row->pax_name, $row->sector, (float) $row->amount);
        }

        $transports = DB::table('transports')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'transports.SID')
            ->where('sale_invoices.type', 4)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.id as invoice_id',
                'transports.pax_name as ticket_chq_ref',
                'transports.pax_name',
                DB::raw('CONCAT(COALESCE(transports.from_date, ""), " - ", COALESCE(transports.to_date, "")) as sector'),
                DB::raw('COALESCE(transports.receiveable, 0) as amount')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('transports.id')
            ->get();

        foreach ($transports as $row) {
            $lines[] = $this->invoiceLine('transfer', $row->voucher_date, $row->invoice_id, $row->ticket_chq_ref, $row->pax_name, $row->sector, (float) $row->amount);
        }

        $others = DB::table('other_sales')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'other_sales.SID')
            ->where('sale_invoices.type', 6)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.id as invoice_id',
                DB::raw('COALESCE(other_sales.pkg_details, "") as ticket_chq_ref'),
                DB::raw('COALESCE(other_sales.pkg_details, "") as pax_name'),
                DB::raw('"" as sector'),
                DB::raw('COALESCE(other_sales.receiveable, 0) as amount')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('other_sales.id')
            ->get();

        foreach ($others as $row) {
            $lines[] = $this->invoiceLine('other', $row->voucher_date, $row->invoice_id, $row->ticket_chq_ref, $row->pax_name, $row->sector, (float) $row->amount);
        }

        usort($lines, function ($a, $b) {
            $dateCmp = strcmp($a['voucher_date'], $b['voucher_date']);
            if ($dateCmp !== 0) {
                return $dateCmp;
            }

            return strcmp($a['kind'], $b['kind']);
        });

        return $lines;
    }

    private function invoiceLine(string $kind, $voucherDate, $invoiceId, $ref, $passenger, $sector, float $amount): array
    {
        return [
            'kind' => $kind,
            'voucher_date' => $voucherDate,
            'v_id' => CommonHelper::dsn($invoiceId),
            'ticket_chq_ref' => $ref,
            'passenger' => $passenger,
            'sector' => $sector,
            'debit' => round($amount, 2),
            'credit' => 0.0,
        ];
    }

    private function collectRefundLines(int $ledgerId, string $df, string $dt): array
    {
        $rows = DB::table('refunds')
            ->where('client_id', $ledgerId)
            ->where('status', 1)
            ->whereBetween(DB::raw('DATE(refund_date)'), [$df, $dt])
            ->orderBy('refund_date')
            ->orderBy('id')
            ->get();

        $lines = [];
        foreach ($rows as $row) {
            $credit = (float) ($row->net_refund ?? $row->refund_amount ?? 0);
            if ($credit <= 0) {
                continue;
            }
            $kind = $this->refundKindFromSaleType((int) $row->refund_to);
            $lines[] = [
                'kind' => $kind,
                'voucher_date' => $row->refund_date,
                'v_id' => CommonHelper::dsn($row->SID),
                'ticket_chq_ref' => $row->ticket_no ?: ($row->remarks ?? ''),
                'passenger' => $row->pax_name,
                'sector' => $row->sector ?? '',
                'debit' => 0.0,
                'credit' => round($credit, 2),
            ];
        }

        return $lines;
    }

    private function collectReceiptLines(int $ledgerId, string $df, string $dt): array
    {
        return DB::table('transactions')
            ->where([
                'trans_acc_id' => $ledgerId,
                'vt' => 1,
                'dr_cr' => 2,
                'status' => 1,
            ])
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get()
            ->map(function ($row) {
                return [
                    'voucher_date' => $row->trans_date,
                    'v_id' => CommonHelper::dsn($row->trans_code),
                    'ticket_chq_ref' => $row->narration,
                    'passenger' => '',
                    'sector' => '',
                    'debit' => 0.0,
                    'credit' => round((float) $row->amount, 2),
                ];
            })
            ->values()
            ->all();
    }

    private function collectPaymentLines(int $ledgerId, string $df, string $dt): array
    {
        return DB::table('transactions')
            ->where([
                'trans_acc_id' => $ledgerId,
                'vt' => 2,
                'dr_cr' => 2,
                'status' => 1,
            ])
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get()
            ->map(function ($row) {
                return [
                    'voucher_date' => $row->trans_date,
                    'v_id' => CommonHelper::dsn($row->trans_code),
                    'ticket_chq_ref' => $row->narration,
                    'passenger' => '',
                    'sector' => '',
                    'debit' => 0.0,
                    'credit' => round((float) $row->amount, 2),
                ];
            })
            ->values()
            ->all();
    }

    private function invoiceTotalsBySaleType(int $ledgerId, string $df, string $dt): array
    {
        $types = [
            'ticket' => 1,
            'hotel' => 2,
            'visa' => 3,
            'transfer' => 4,
            'other' => 6,
        ];
        $totals = [];
        foreach ($types as $key => $typeId) {
            $totals[$key] = $this->sumReceivableForType($ledgerId, $df, $dt, $typeId);
        }

        return $totals;
    }

    private function sumReceivableForType(int $ledgerId, string $df, string $dt, int $typeId): float
    {
        $tableMap = [
            1 => 'tickets',
            2 => 'lead_hotels',
            3 => 'visas',
            4 => 'transports',
            6 => 'other_sales',
        ];
        $detailTable = $tableMap[$typeId] ?? null;
        if (!$detailTable) {
            return 0.0;
        }

        return (float) DB::table($detailTable)
            ->join('sale_invoices', 'sale_invoices.id', '=', $detailTable . '.SID')
            ->where('sale_invoices.type', $typeId)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->sum(DB::raw('COALESCE(' . $detailTable . '.receiveable, 0)'));
    }

    private function refundTotalsBySaleType(int $ledgerId, string $df, string $dt): array
    {
        $keys = ['ticket' => 1, 'hotel' => 2, 'visa' => 3, 'transfer' => 4, 'other' => 5];
        $totals = [];
        foreach ($keys as $key => $refundTo) {
            $totals[$key] = (float) DB::table('refunds')
                ->where('client_id', $ledgerId)
                ->where('refund_to', $refundTo)
                ->where('status', 1)
                ->whereBetween(DB::raw('DATE(refund_date)'), [$df, $dt])
                ->sum(DB::raw('COALESCE(net_refund, refund_amount, 0)'));
        }

        return $totals;
    }

    private function refundKindFromSaleType(int $refundTo): string
    {
        return match ($refundTo) {
            1 => 'ticket',
            2 => 'hotel',
            3 => 'visa',
            4 => 'transfer',
            default => 'other',
        };
    }
}
