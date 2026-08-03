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
 * Sale Report Ledger — statement for a receivable / cash-sale ledger account.
 *
 * Matches the legacy print layout: ticket invoices, visa invoices, receipts,
 * and a balance summary (B/F, invoice debits, receipt credits, closing balance).
 */
class SaleReportLedgerController extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Ledger.sale_report_ledger.index');
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

        $ticketRows = DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->where('sale_invoices.type', 1)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'tickets.departure_date',
                'tickets.return_date as arrival_date',
                'sale_invoices.id as invoice_id',
                'tickets.ticket_no',
                'tickets.pax_name',
                'tickets.sector',
                DB::raw('COALESCE(tickets.receiveable, 0) as debit'),
                DB::raw('0 as credit')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('tickets.id')
            ->get();

        $visaRows = DB::table('visas')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'visas.SID')
            ->leftJoin('countries', 'visas.visa_country', '=', 'countries.id')
            ->where('sale_invoices.type', 3)
            ->where('sale_invoices.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt])
            ->select(
                'sale_invoices.inv_date as voucher_date',
                'sale_invoices.inv_date as visa_date',
                'sale_invoices.id as invoice_id',
                'visas.visa_no',
                'visas.pax_name as application_name',
                DB::raw('COALESCE(countries.name, "") as country'),
                DB::raw('COALESCE(visas.receiveable, 0) as debit'),
                DB::raw('0 as credit')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('visas.id')
            ->get();

        $receiptRows = DB::table('transactions')
            ->where([
                'trans_acc_id' => $ledgerId,
                'vt' => 1,
                'dr_cr' => 2,
                'status' => 1,
            ])
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->select(
                'trans_date as voucher_date',
                'trans_code',
                'narration',
                DB::raw('0 as debit'),
                'amount as credit'
            )
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get();

        $ticketDebit = $ticketRows->sum('debit');
        $visaDebit = $visaRows->sum('debit');
        $receiptCredit = $receiptRows->sum('credit');
        $invoiceDebit = $ticketDebit + $visaDebit;
        $closingBalance = $openingBalance + $invoiceDebit - $receiptCredit;

        $formatRow = function ($row, $type) {
            if ($type === 'ticket') {
                return [
                    'voucher_date' => $row->voucher_date,
                    'departure' => $row->departure_date,
                    'arrival' => $row->arrival_date,
                    'v_id' => CommonHelper::dsn($row->invoice_id),
                    'ticket' => $row->ticket_no,
                    'passenger_name' => $row->pax_name,
                    'sector' => $row->sector,
                    'debit' => round((float) $row->debit, 2),
                    'credit' => round((float) $row->credit, 2),
                ];
            }
            if ($type === 'visa') {
                return [
                    'voucher_date' => $row->voucher_date,
                    'visa_date' => $row->visa_date,
                    'v_id' => CommonHelper::dsn($row->invoice_id),
                    'visa_no' => $row->visa_no,
                    'application_name' => $row->application_name,
                    'country' => $row->country,
                    'debit' => round((float) $row->debit, 2),
                    'credit' => round((float) $row->credit, 2),
                ];
            }

            return [
                'voucher_date' => $row->voucher_date,
                'voucher_no' => CommonHelper::dsn($row->trans_code),
                'narration' => $row->narration,
                'debit' => round((float) $row->debit, 2),
                'credit' => round((float) $row->credit, 2),
            ];
        };

        return response()->json([
            'ledger_name' => $ledger->Trans_Acc_Name,
            'opening_balance' => round($openingBalance, 2),
            'opening_balance_label' => Account::show_bal($openingBalance),
            'ticket_invoices' => $ticketRows->map(fn ($r) => $formatRow($r, 'ticket'))->values(),
            'ticket_totals' => [
                'count' => $ticketRows->count(),
                'debit' => round($ticketDebit, 2),
                'credit' => 0,
            ],
            'visa_invoices' => $visaRows->map(fn ($r) => $formatRow($r, 'visa'))->values(),
            'visa_totals' => [
                'count' => $visaRows->count(),
                'debit' => round($visaDebit, 2),
                'credit' => 0,
            ],
            'receipts' => $receiptRows->map(fn ($r) => $formatRow($r, 'receipt'))->values(),
            'receipt_totals' => [
                'count' => $receiptRows->count(),
                'debit' => 0,
                'credit' => round($receiptCredit, 2),
            ],
            'summary' => [
                'balance_bf' => round($openingBalance, 2),
                'balance_bf_label' => Account::show_bal($openingBalance),
                'ticket_invoices' => round($ticketDebit, 2),
                'visa_invoices' => round($visaDebit, 2),
                'invoices_total' => round($invoiceDebit, 2),
                'invoices_total_label' => Account::show_bal($invoiceDebit),
                'receipts_total' => round($receiptCredit, 2),
                'receipts_total_label' => Account::show_bal(-$receiptCredit),
                'vouchers_total_label' => Account::show_bal(-$receiptCredit),
                'closing_balance' => round($closingBalance, 2),
                'closing_balance_label' => Account::show_bal($closingBalance),
            ],
        ]);
    }
}
