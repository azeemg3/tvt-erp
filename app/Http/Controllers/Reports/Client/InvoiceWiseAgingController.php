<?php

namespace App\Http\Controllers\Reports\Client;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reports\ParsesReportDates;
use App\Models\Accounts\TransactionAccount;
use App\Models\Client;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use PDF;

/**
 * Invoice Wise Aging — layout matches the attached aging PDF sample;
 * amounts are loaded live from sale_invoices, line items and transactions.
 */
class InvoiceWiseAgingController extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Client.invoice_wise_aging.index');
    }

    public function get_data(Request $request)
    {
        $request->validate([
            'ledger' => 'required|integer',
        ]);

        try {
            $payload = $this->buildReportPayload($request);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($payload);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'ledger' => 'required|integer',
        ]);

        try {
            $payload = $this->buildReportPayload($request);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        $company = Company::current();
        $viewData = [
            'company' => $company,
            'clientLabel' => $payload['client_label'],
            'clientCode' => $payload['client_code'],
            'clientName' => $payload['client_name'],
            'invoices' => $payload['invoices'],
            'invoiceTotals' => $payload['invoice_totals'],
            'unadjusted' => $payload['unadjusted_vouchers'],
            'unadjustedTotals' => $payload['unadjusted_totals'],
            'clientTotals' => $payload['client_totals'],
            'printedBy' => $payload['printed_by'],
            'df' => $request->input('df'),
            'dt' => $request->input('dt'),
            'printOn' => now()->format('d/m/Y'),
        ];

        $pdf = PDF::getPdf([
            'format' => 'A4',
            'orientation' => 'L',
            'margin_left' => 8,
            'margin_right' => 8,
            'margin_top' => 8,
            'margin_bottom' => 14,
        ]);
        $pdf->getMpdf()->SetHTMLFooter(
            view('Reports.partials.pdf_page_footer', ['company' => $company])->render()
        );
        $pdf->getMpdf()->WriteHTML(
            view('Reports.Client.invoice_wise_aging.pdf', $viewData)->render()
        );

        return $pdf->download('invoice_wise_aging_' . date('Ymd_His') . '.pdf');
    }

    /**
     * @throws InvalidArgumentException
     */
    private function buildReportPayload(Request $request): array
    {
        [$df, $dt] = $this->parseReportDateRange($request);

        $ledgerId = (int) $request->ledger;
        $ledger = TransactionAccount::find($ledgerId);
        if (!$ledger) {
            throw new InvalidArgumentException('Client ledger account not found.');
        }

        $client = Client::where('account_id', $ledgerId)->first();
        $creditDays = (int) ($client->credit_days ?? 0);
        $asOf = Carbon::parse($dt);

        $invoiceRows = $this->buildInvoiceSection($ledgerId, $df, $dt, $asOf, $creditDays);
        $voucherRows = $this->buildUnadjustedVouchers($ledgerId, $df, $dt);

        $invoiceTotals = $this->sumColumns($invoiceRows);
        $voucherTotals = $this->sumColumns($voucherRows);
        $clientTotals = $this->sumColumns(array_merge($invoiceRows, $voucherRows));

        return [
            'client_label' => $this->clientLabel($ledger, $client),
            'client_code' => $this->clientCode($ledger),
            'client_name' => strtoupper($client->client_name ?? $ledger->Trans_Acc_Name),
            'ledger_name' => $ledger->Trans_Acc_Name,
            'invoices' => $invoiceRows,
            'invoice_totals' => $invoiceTotals,
            'unadjusted_vouchers' => $voucherRows,
            'unadjusted_totals' => $voucherTotals,
            'client_totals' => $clientTotals,
            'printed_by' => Auth::user()->name ?? '',
        ];
    }

    private function buildInvoiceSection(int $ledgerId, string $df, string $dt, Carbon $asOf, int $creditDays): array
    {
        $invoices = DB::table('sale_invoices as si')
            ->where('si.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(si.inv_date)'), [$df, $dt])
            ->orderBy('si.inv_date')
            ->orderBy('si.id')
            ->get(['si.id', 'si.inv_date', 'si.due_date', 'si.type', 'si.remarks', 'si.trans_code']);

        $rows = [];
        foreach ($invoices as $invoice) {
            $netInvoice = $this->invoiceNetAmount((int) $invoice->id);
            if ($netInvoice <= 0) {
                continue;
            }

            $invoiceId = (int) $invoice->id;
            $lessReceipts = $this->sumClientTransactions($ledgerId, $invoiceId, 1, 2);
            $addPayment = $this->sumClientTransactions($ledgerId, $invoiceId, [2, 3], 1);
            $lessRefund = $this->sumRefunds($ledgerId, $invoiceId);
            $balanceAmount = round($netInvoice - $lessReceipts - $lessRefund + $addPayment, 2);

            if (abs($balanceAmount) < 0.005) {
                continue;
            }

            $dueDate = $this->resolveDueDate($invoice->due_date, $invoice->inv_date, $creditDays);
            $daysOver = $asOf->gt($dueDate) ? $dueDate->diffInDays($asOf) : 0;

            $detail = $this->invoicePassengerRemarks($invoiceId, (int) $invoice->type, (string) $invoice->remarks);

            $rows[] = [
                'passenger_remarks' => $detail['passenger_remarks'],
                'extra_remarks' => $detail['extra_remarks'],
                'doc_label' => $this->formatInvoiceDocLabel($invoiceId, (int) $invoice->type, $invoice->inv_date),
                'xo_no' => $invoice->trans_code ? (string) $invoice->trans_code : '',
                'net_invoice' => round($netInvoice, 2),
                'less_receipts' => round($lessReceipts, 2),
                'less_refund' => round($lessRefund, 2),
                'add_payment' => round($addPayment, 2),
                'days_over' => $daysOver,
                'balance_amount' => $balanceAmount,
            ];
        }

        return $rows;
    }

    private function buildUnadjustedVouchers(int $ledgerId, string $df, string $dt): array
    {
        $transactions = DB::table('transactions')
            ->where('trans_acc_id', $ledgerId)
            ->where('status', 1)
            ->whereIn('vt', [1, 2, 3])
            ->where(function ($q) {
                $q->whereNull('SID')->orWhere('SID', 0);
            })
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get();

        $rows = [];
        foreach ($transactions as $row) {
            $amount = (float) $row->amount;
            $isDebit = (int) $row->dr_cr === 1;
            $vt = (int) $row->vt;

            // Debit PV/JV -> Add Payment only; Credit RV -> Less Receipts; other credits reduce balance.
            $netInvoice = 0.0;
            $lessReceipts = 0.0;
            $addPayment = 0.0;
            $lessRefund = 0.0;
            if ($isDebit && in_array($vt, [2, 3], true)) {
                $addPayment = round($amount, 2);
            } elseif ($isDebit) {
                $netInvoice = round($amount, 2);
            } elseif ($vt === 1) {
                $lessReceipts = round($amount, 2);
            }
            $balanceAmount = round($netInvoice - $lessReceipts - $lessRefund + $addPayment, 2);
            if (!$isDebit && $vt !== 1) {
                $balanceAmount = round(-$amount, 2);
            }

            if (abs($balanceAmount) < 0.005 && abs($netInvoice) < 0.005 && abs($lessReceipts) < 0.005) {
                continue;
            }

            $rows[] = [
                'passenger_remarks' => (string) $row->narration,
                'extra_remarks' => '',
                'doc_label' => $this->formatVoucherLabel($vt, (int) $row->trans_code, $row->trans_date),
                'xo_no' => '',
                'net_invoice' => $netInvoice,
                'less_receipts' => $lessReceipts,
                'less_refund' => $lessRefund,
                'add_payment' => $addPayment,
                'days_over' => 0,
                'balance_amount' => $balanceAmount,
            ];
        }

        return $rows;
    }

    private function invoiceNetAmount(int $invoiceId): float
    {
        $tables = ['tickets', 'lead_hotels', 'visas', 'transports', 'other_sales'];
        $total = 0.0;
        foreach ($tables as $table) {
            $total += (float) DB::table($table)
                ->where('SID', $invoiceId)
                ->sum(DB::raw('COALESCE(receiveable, 0)'));
        }

        if ($total > 0) {
            return $total;
        }

        return (float) DB::table('transactions')
            ->where('SID', $invoiceId)
            ->where('dr_cr', 1)
            ->where('status', 1)
            ->whereIn('vt', [4, 5, 6, 7, 8, 10, 11, 12])
            ->sum('amount');
    }

    private function sumClientTransactions(int $ledgerId, int $invoiceId, $vt, int $drCr): float
    {
        $vtList = is_array($vt) ? $vt : [$vt];

        return (float) DB::table('transactions')
            ->where([
                'trans_acc_id' => $ledgerId,
                'SID' => $invoiceId,
                'dr_cr' => $drCr,
                'status' => 1,
            ])
            ->whereIn('vt', $vtList)
            ->sum('amount');
    }

    private function sumRefunds(int $ledgerId, int $invoiceId): float
    {
        $fromTable = (float) DB::table('refunds')
            ->where([
                'client_id' => $ledgerId,
                'SID' => $invoiceId,
                'status' => 1,
            ])
            ->sum(DB::raw('COALESCE(net_refund, refund_amount, 0)'));

        $fromTrans = (float) DB::table('transactions')
            ->where([
                'trans_acc_id' => $ledgerId,
                'SID' => $invoiceId,
                'dr_cr' => 2,
                'status' => 1,
                'vt' => 9,
            ])
            ->sum('amount');

        return $fromTable + $fromTrans;
    }

    private function invoicePassengerRemarks(int $invoiceId, int $type, string $invoiceRemarks): array
    {
        $paxNames = [];
        $suffix = '';

        if ($type === 1) {
            $ticketRows = DB::table('tickets')
                ->leftJoin('airlines', 'tickets.airline', '=', 'airlines.id')
                ->where('tickets.SID', $invoiceId)
                ->select('tickets.pax_name', 'tickets.ticket_no', 'tickets.ticket_type', 'airlines.name as airline_name')
                ->get();

            $count = $ticketRows->count();
            if ($count > 0) {
                $first = $ticketRows->first();
                $airCode = $this->airlineCode($first->ticket_no, $first->airline_name);
                $intlDom = ((int) $first->ticket_type === 1) ? 'Dom' : 'Int';
                $suffix = trim($airCode . '-' . $intlDom, '-');
                $paxNames[] = strtoupper($first->pax_name) . ($count > 1 ? ' x ' . $count : ' x 1');
            }
        } elseif ($type === 2) {
            $hotelRows = DB::table('lead_hotels')->where('SID', $invoiceId)->pluck('pax_name');
            $count = $hotelRows->count();
            if ($count > 0) {
                $paxNames[] = strtoupper($hotelRows->first()) . ' x ' . max(1, $count);
            }
        } elseif ($type === 3) {
            $visaRows = DB::table('visas')->where('SID', $invoiceId)->pluck('pax_name');
            $count = $visaRows->count();
            if ($count > 0) {
                $paxNames[] = strtoupper($visaRows->first()) . ' x ' . max(1, $count);
            }
        } elseif ($type === 4) {
            $rows = DB::table('transports')->where('SID', $invoiceId)->pluck('pax_name');
            $count = $rows->count();
            if ($count > 0) {
                $paxNames[] = strtoupper($rows->first()) . ' x ' . max(1, $count);
            }
        } else {
            $other = DB::table('other_sales')->where('SID', $invoiceId)->value('pkg_details');
            if ($other) {
                $paxNames[] = strtoupper($other);
            }
        }

        $passenger = trim(implode(' ', $paxNames) . ' ' . $suffix);
        if ($passenger === '') {
            $passenger = strtoupper(trim($invoiceRemarks));
        }

        $extra = '';
        if (in_array($type, [5, 6], true) && trim($invoiceRemarks) !== '') {
            $extra = trim($invoiceRemarks);
        }

        return [
            'passenger_remarks' => $passenger,
            'extra_remarks' => $extra,
        ];
    }

    private function airlineCode(?string $ticketNo, ?string $airlineName): string
    {
        if ($ticketNo && preg_match('/^([A-Z0-9]{2})/i', $ticketNo, $m)) {
            return strtoupper($m[1]);
        }
        if ($airlineName) {
            $parts = preg_split('/\s+/', trim($airlineName));

            return strtoupper(substr($parts[0], 0, 2));
        }

        return '';
    }

    private function formatInvoiceDocLabel(int $invoiceId, int $type, $invDate): string
    {
        $date = Carbon::parse($invDate)->format('d/m/y');
        $prefix = in_array($type, [5, 6], true) ? 'UB' : '';
        $number = $prefix . str_pad((string) $invoiceId, 6, '0', STR_PAD_LEFT);

        return $date . ' - ' . $number;
    }

    private function formatVoucherLabel(int $vt, int $transCode, $transDate): string
    {
        $date = Carbon::parse($transDate)->format('d/m/y');
        $prefix = Account::vt($vt);
        $number = $prefix . str_pad((string) $transCode, 6, '0', STR_PAD_LEFT);

        return $date . ' - ' . $number;
    }

    private function resolveDueDate($dueDate, $invDate, int $creditDays): Carbon
    {
        if (!empty($dueDate)) {
            return Carbon::parse($dueDate);
        }
        $base = Carbon::parse($invDate);
        if ($creditDays > 0) {
            return $base->copy()->addDays($creditDays);
        }

        return $base;
    }

    private function clientCode(TransactionAccount $ledger): string
    {
        $code = (string) ($ledger->code ?? '');
        if ($code !== '' && strlen($code) > 4 && strpos($code, '-') === false) {
            $code = substr($code, 0, 4) . '-' . substr($code, 4);
        }

        return $code;
    }

    private function clientLabel(TransactionAccount $ledger, ?Client $client): string
    {
        $code = $this->clientCode($ledger);
        $name = $client->client_name ?? $ledger->Trans_Acc_Name;

        return trim($code . ' ' . strtoupper($name));
    }

    private function sumColumns(array $rows): array
    {
        $totals = [
            'net_invoice' => 0.0,
            'less_receipts' => 0.0,
            'less_refund' => 0.0,
            'add_payment' => 0.0,
            'balance_amount' => 0.0,
        ];
        foreach ($rows as $row) {
            foreach (array_keys($totals) as $key) {
                $totals[$key] += (float) ($row[$key] ?? 0);
            }
        }
        foreach ($totals as $key => $value) {
            $totals[$key] = round($value, 2);
        }

        return $totals;
    }
}
