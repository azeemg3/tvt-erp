<?php

namespace App\Http\Controllers\Reports\Sale;

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
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
use PDF;

/**
 * Account Statement reports — layout matches the attached PDF samples;
 * all rows/totals are loaded live from sale_invoices, tickets and transactions.
 */
class AccountStatementReportController extends Controller
{
    use ParsesReportDates;

    /** @var string invoice|ticket */
    protected string $reportMode = 'invoice';

    public function index()
    {
        $isTicket = $this->reportMode === 'ticket';

        return view('Reports.Sale.account_statement.index', [
            'reportMode' => $this->reportMode,
            'reportTitle' => $isTicket
                ? 'Account Statement (Ticket Wise)'
                : 'Account Statement (Invoice Wise)',
            'reportSlug' => $isTicket
                ? 'account_statement_ticket_wise'
                : 'account_statement_invoice_wise',
            'dataUrl' => url('reports/sale/get_account_statement_' . ($isTicket ? 'ticket_wise' : 'invoice_wise')),
            'pdfUrl' => url('reports/sale/pdf_account_statement_' . ($isTicket ? 'ticket_wise' : 'invoice_wise')),
        ]);
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

        $isTicket = $this->reportMode === 'ticket';
        $reportTitle = $isTicket
            ? 'Account Statement (Ticket Wise)'
            : 'Account Statement (Invoice Wise)';
        $company = Company::current();
        $df = $request->input('df');
        $dt = $request->input('dt');

        $viewData = [
            'reportTitle' => $reportTitle,
            'reportMode' => $this->reportMode,
            'company' => $company,
            'clientLabel' => $payload['client_label'],
            'clientCode' => $payload['client_code'],
            'clientName' => $payload['client_name'],
            'invoices' => $payload['invoices'],
            'invoiceTotals' => $payload['invoice_totals'],
            'receipts' => $payload['receipts'],
            'receiptTotals' => $payload['receipt_totals'],
            'printedBy' => $payload['printed_by'],
            'df' => $df,
            'dt' => $dt,
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
            view('Reports.Sale.account_statement.pdf', $viewData)->render()
        );

        $slug = $isTicket ? 'account_statement_ticket_wise' : 'account_statement_invoice_wise';

        return $pdf->download($slug . '_' . date('Ymd_His') . '.pdf');
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
        $invoiceRows = $this->reportMode === 'ticket'
            ? $this->buildTicketWiseRows($ledgerId, $df, $dt)
            : $this->buildInvoiceWiseRows($ledgerId, $df, $dt);
        $receiptRows = $this->buildReceiptPaymentRows($ledgerId, $df, $dt);

        return [
            'client_label' => $this->clientLabel($ledger, $client),
            'client_code' => $this->clientCode($ledger),
            'client_name' => strtoupper($client->client_name ?? $ledger->Trans_Acc_Name),
            'ledger_name' => $ledger->Trans_Acc_Name,
            'report_mode' => $this->reportMode,
            'invoices' => $invoiceRows,
            'invoice_totals' => $this->sumAmountColumns($invoiceRows),
            'receipts' => $receiptRows,
            'receipt_totals' => $this->sumReceiptColumns($receiptRows),
            'printed_by' => Auth::user()->name ?? '',
        ];
    }

    /**
     * Invoice Wise: one aggregated row per sale invoice (live DB).
     */
    private function buildInvoiceWiseRows(int $ledgerId, string $df, string $dt): array
    {
        $invoices = DB::table('sale_invoices as si')
            ->where('si.ledger', $ledgerId)
            ->whereBetween(DB::raw('DATE(si.inv_date)'), [$df, $dt])
            ->orderBy('si.inv_date')
            ->orderBy('si.id')
            ->get(['si.id', 'si.inv_date', 'si.trans_code', 'si.type', 'si.remarks']);

        $rows = [];
        foreach ($invoices as $invoice) {
            $invoiceId = (int) $invoice->id;
            $type = (int) $invoice->type;
            $detail = $this->invoiceDetailLines($invoiceId, $type, (string) ($invoice->remarks ?? ''));

            if (empty($detail['lines'])) {
                continue;
            }

            $amounts = $this->sumLines($detail['lines']);
            if (abs($amounts['net_amount']) < 0.005 && abs($amounts['fare']) < 0.005) {
                continue;
            }

            $rows[] = [
                'date' => $this->formatDate($invoice->inv_date),
                'xo_no' => $invoice->trans_code ? (string) $invoice->trans_code : '',
                'invoice_number' => $this->formatInvoiceNumber($invoiceId, $type),
                'passenger_name' => $detail['label'],
                'fare' => $amounts['fare'],
                'taxes' => $amounts['taxes'],
                'sp' => $amounts['sp'],
                'kb' => $amounts['kb'],
                'net_amount' => $amounts['net_amount'],
            ];
        }

        return $rows;
    }

    /**
     * Ticket Wise: one row per ticket (live DB).
     */
    private function buildTicketWiseRows(int $ledgerId, string $df, string $dt): array
    {
        $tickets = DB::table('tickets')
            ->join('sale_invoices as si', 'si.id', '=', 'tickets.SID')
            ->leftJoin('airlines', 'tickets.airline', '=', 'airlines.id')
            ->where('si.ledger', $ledgerId)
            ->where('si.type', 1)
            ->whereBetween(DB::raw('DATE(si.inv_date)'), [$df, $dt])
            ->orderBy('si.inv_date')
            ->orderBy('si.id')
            ->orderBy('tickets.id')
            ->select(
                'si.inv_date',
                'si.trans_code',
                'si.id as invoice_id',
                'si.type as invoice_type',
                'tickets.pax_name',
                'tickets.ticket_no',
                'tickets.sector',
                'tickets.basic_fare',
                'tickets.taxes',
                'tickets.total_taxes',
                'tickets.discount',
                'tickets.psf',
                'tickets.agent_amount',
                'tickets.receiveable',
                'airlines.name as airline_name'
            )
            ->get();

        $rows = [];
        foreach ($tickets as $ticket) {
            $amounts = $this->lineAmounts($ticket);
            $rows[] = [
                'date' => $this->formatDate($ticket->inv_date),
                'xo_no' => $ticket->trans_code ? (string) $ticket->trans_code : '',
                'invoice_number' => $this->formatInvoiceNumber((int) $ticket->invoice_id, (int) $ticket->invoice_type),
                'passenger_name' => strtoupper(trim((string) $ticket->pax_name)),
                'ticket_number' => $this->formatTicketNumber((string) ($ticket->ticket_no ?? '')),
                'sector' => (string) ($ticket->sector ?? ''),
                'fare' => $amounts['fare'],
                'taxes' => $amounts['taxes'],
                'sp' => $amounts['sp'],
                'kb' => $amounts['kb'],
                'net_amount' => $amounts['net_amount'],
            ];
        }

        return $rows;
    }

    private function invoiceDetailLines(int $invoiceId, int $type, string $remarks): array
    {
        if ($type === 1) {
            $ticketRows = DB::table('tickets')
                ->leftJoin('airlines', 'tickets.airline', '=', 'airlines.id')
                ->where('tickets.SID', $invoiceId)
                ->select(
                    'tickets.pax_name',
                    'tickets.ticket_no',
                    'tickets.ticket_type',
                    'tickets.basic_fare',
                    'tickets.taxes',
                    'tickets.total_taxes',
                    'tickets.discount',
                    'tickets.psf',
                    'tickets.agent_amount',
                    'tickets.receiveable',
                    'airlines.name as airline_name'
                )
                ->orderBy('tickets.id')
                ->get();

            $lines = [];
            foreach ($ticketRows as $ticket) {
                $lines[] = $this->lineAmounts($ticket);
            }

            $count = $ticketRows->count();
            $label = '';
            if ($count > 0) {
                $first = $ticketRows->first();
                $airCode = $this->airlineCode($first->ticket_no, $first->airline_name ?? null);
                $intlDom = ((int) ($first->ticket_type ?? 0) === 1) ? 'Dom' : 'Int';
                $suffix = trim($airCode . '-' . $intlDom, '-');
                $label = trim(strtoupper(trim((string) $first->pax_name)) . ' x ' . max(1, $count) . ' ' . $suffix);
            }

            return ['lines' => $lines, 'label' => $label ?: strtoupper(trim($remarks))];
        }

        $tableMap = [
            2 => ['lead_hotels', 'pax_name'],
            3 => ['visas', 'pax_name'],
            4 => ['transports', 'pax_name'],
            6 => ['other_sales', 'pkg_details'],
        ];

        if (!isset($tableMap[$type])) {
            return ['lines' => [], 'label' => strtoupper(trim($remarks))];
        }

        [$table, $nameCol] = $tableMap[$type];
        $detailRows = DB::table($table)->where('SID', $invoiceId)->get();
        if ($detailRows->isEmpty()) {
            return ['lines' => [], 'label' => strtoupper(trim($remarks))];
        }

        $lines = [];
        foreach ($detailRows as $row) {
            $fare = round((float) ($row->basic_fare ?? $row->fare ?? 0), 2);
            $taxes = round((float) ($row->total_taxes ?? $row->taxes ?? 0), 2);
            $sp = round((float) ($row->discount ?? 0), 2);
            $kb = round((float) ($row->agent_amount ?? 0), 2);
            $receiveable = round((float) ($row->receiveable ?? 0), 2);
            $net = $receiveable != 0.0
                ? $receiveable
                : round($fare + $taxes - $sp - $kb, 2);

            $lines[] = compact('fare', 'taxes', 'sp', 'kb') + ['net_amount' => $net];
        }

        $firstName = strtoupper(trim((string) ($detailRows->first()->{$nameCol} ?? '')));
        $count = $detailRows->count();
        $label = $firstName !== ''
            ? $firstName . ($type === 6 ? '' : ' x ' . max(1, $count))
            : strtoupper(trim($remarks));

        return ['lines' => $lines, 'label' => $label];
    }

    private function lineAmounts(object $row): array
    {
        $fare = round((float) ($row->basic_fare ?? 0), 2);
        $taxesRaw = (float) ($row->total_taxes ?? 0);
        $taxes = round($taxesRaw != 0.0 ? $taxesRaw : (float) ($row->taxes ?? 0), 2);
        $sp = round((float) ($row->discount ?? 0), 2);
        $kb = round((float) ($row->agent_amount ?? 0), 2);
        $receiveable = round((float) ($row->receiveable ?? 0), 2);

        // Prefer stored receiveable (live sale figure); fall back to formula.
        $net = $receiveable != 0.0
            ? $receiveable
            : round($fare + $taxes + (float) ($row->psf ?? 0) - $sp - $kb, 2);

        return [
            'fare' => $fare,
            'taxes' => $taxes,
            'sp' => $sp,
            'kb' => $kb,
            'net_amount' => $net,
        ];
    }

    private function sumLines(array $lines): array
    {
        $totals = [
            'fare' => 0.0,
            'taxes' => 0.0,
            'sp' => 0.0,
            'kb' => 0.0,
            'net_amount' => 0.0,
        ];
        foreach ($lines as $line) {
            foreach ($totals as $key => $value) {
                $totals[$key] = round($value + (float) ($line[$key] ?? 0), 2);
            }
        }

        return $totals;
    }

    private function buildReceiptPaymentRows(int $ledgerId, string $df, string $dt): array
    {
        $select = [
            'trans_date',
            'trans_code',
            'vt',
            'SID',
            'payment_type',
            'narration',
            'amount',
            'dr_cr',
        ];

        $hasChequeNo = Schema::hasColumn('transactions', 'cheque_no');
        if ($hasChequeNo) {
            $select[] = 'cheque_no';
        }

        $transactions = DB::table('transactions')
            ->where('trans_acc_id', $ledgerId)
            ->where('status', 1)
            ->whereIn('vt', [1, 2, 3])
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get($select);

        $rows = [];
        foreach ($transactions as $row) {
            $amount = round((float) $row->amount, 2);
            $isDebit = (int) $row->dr_cr === 1;
            $sid = (int) ($row->SID ?? 0);

            $cheque = '';
            if ($hasChequeNo && !empty($row->cheque_no)) {
                $cheque = (string) $row->cheque_no;
            } else {
                $cheque = $this->paymentTypeLabel($row->payment_type);
            }

            $rows[] = [
                'trans_date' => $this->formatDate($row->trans_date),
                'voucher_number' => $this->formatVoucherNumber((int) $row->vt, (int) $row->trans_code),
                'invoice_number' => $sid > 0 ? $this->formatInvoiceNumber($sid) : '-',
                'cheque_number' => $cheque,
                'remarks' => (string) ($row->narration ?? ''),
                'receipts' => $isDebit ? 0.0 : $amount,
                'payments' => $isDebit ? $amount : 0.0,
            ];
        }

        return $rows;
    }

    private function airlineCode(?string $ticketNo, ?string $airlineName): string
    {
        $digits = preg_replace('/\D+/', '', (string) $ticketNo);
        if ($digits !== '' && strlen($digits) >= 3) {
            // Common airline numeric prefix (e.g. 772 = PK) — keep alpha from ticket when present.
        }
        if ($ticketNo && preg_match('/^([A-Z]{2})/i', $ticketNo, $m)) {
            return strtoupper($m[1]);
        }
        if ($airlineName) {
            $parts = preg_split('/\s+/', trim($airlineName));

            return strtoupper(substr($parts[0], 0, 2));
        }

        return '';
    }

    private function formatTicketNumber(string $ticketNo): string
    {
        $clean = preg_replace('/\s+/', '', $ticketNo);
        $digits = preg_replace('/\D+/', '', $clean);
        if (strlen($digits) === 13) {
            return substr($digits, 0, 3) . '-' . substr($digits, 3, 4) . '-' . substr($digits, 7, 3) . '-' . substr($digits, 10, 3);
        }

        return $ticketNo;
    }

    private function formatInvoiceNumber(int $invoiceId, int $type = 0): string
    {
        $prefix = in_array($type, [5, 6], true) ? 'UB' : '';

        return $prefix . str_pad((string) $invoiceId, 6, '0', STR_PAD_LEFT);
    }

    private function formatVoucherNumber(int $vt, int $transCode): string
    {
        return Account::vt($vt) . '-' . str_pad((string) $transCode, 6, '0', STR_PAD_LEFT);
    }

    private function formatDate($date): string
    {
        if (empty($date)) {
            return '';
        }

        return Carbon::parse($date)->format('Y-m-d');
    }

    private function paymentTypeLabel($paymentType): string
    {
        $map = [
            1 => 'Cash',
            2 => 'Cheque',
            3 => 'ONLINE',
            4 => 'Credit',
        ];

        if (is_string($paymentType) && !is_numeric($paymentType) && trim($paymentType) !== '') {
            return strtoupper(trim($paymentType));
        }

        $key = (int) $paymentType;

        return $map[$key] ?? '';
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

    private function sumAmountColumns(array $rows): array
    {
        $totals = [
            'fare' => 0.0,
            'taxes' => 0.0,
            'sp' => 0.0,
            'kb' => 0.0,
            'net_amount' => 0.0,
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

    private function sumReceiptColumns(array $rows): array
    {
        $totals = [
            'receipts' => 0.0,
            'payments' => 0.0,
        ];
        foreach ($rows as $row) {
            $totals['receipts'] += (float) ($row['receipts'] ?? 0);
            $totals['payments'] += (float) ($row['payments'] ?? 0);
        }
        $totals['receipts'] = round($totals['receipts'], 2);
        $totals['payments'] = round($totals['payments'], 2);

        return $totals;
    }
}
