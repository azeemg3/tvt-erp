<?php

namespace App\Http\Controllers\Reports\Client;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reports\ParsesReportDates;
use App\Models\Accounts\TransactionAccount;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
use PDF;

/**
 * Client Position Report — period activity summary matching the attached PDF:
 * Opening Bal, Invoice, Debit Note, Void/Refund, Bookings, Cancellations,
 * Receipts, Payments, Closing Bal.
 */
class ClientPositionReportController extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Client.client_position_report.index', [
            'categories' => Client::CATEGORIES,
        ]);
    }

    public function get_data(Request $request)
    {
        try {
            $payload = $this->buildReportPayload($request);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($payload);
    }

    public function exportPdf(Request $request)
    {
        try {
            $payload = $this->buildReportPayload($request);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        $company = Company::current();
        $viewData = [
            'company' => $company,
            'rows' => $payload['rows'],
            'totals' => $payload['totals'],
            'categoryLabel' => $payload['category_label'],
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
            view('Reports.Client.client_position_report.pdf', $viewData)->render()
        );

        return $pdf->download('client_position_report_' . date('Ymd_His') . '.pdf');
    }

    /**
     * @throws InvalidArgumentException
     */
    private function buildReportPayload(Request $request): array
    {
        [$df, $dt] = $this->parseReportDateRange($request);
        $ledgerFilter = $request->filled('ledger') ? (int) $request->ledger : null;
        $categoryFilter = trim((string) $request->input('category', ''));

        $ledgers = TransactionAccount::query()
            ->whereIn('PID', [2, 21])
            ->when($ledgerFilter, fn ($q) => $q->where('id', $ledgerFilter))
            ->orderBy('Trans_Acc_Name')
            ->get(['id', 'code', 'Trans_Acc_Name']);

        $clientsByAccount = Client::query()
            ->whereIn('account_id', $ledgers->pluck('id'))
            ->get()
            ->keyBy('account_id');

        if ($categoryFilter !== '') {
            $ledgers = $ledgers->filter(function ($ledger) use ($clientsByAccount, $categoryFilter) {
                $client = $clientsByAccount->get($ledger->id);

                return $client && (string) $client->category === $categoryFilter;
            })->values();
        }

        $invoiceByLedger = $this->sumInvoiceReceivableByLedger($ledgers->pluck('id')->all(), $df, $dt);
        $debitNoteByLedger = $this->sumDebitNotesByLedger($ledgers->pluck('id')->all(), $df, $dt);
        $refundByLedger = $this->sumRefundsByLedger($ledgers->pluck('id')->all(), $df, $dt);
        $bookingByLedger = $this->sumBookingsByLedger($ledgers->pluck('id')->all(), $df, $dt);
        $cancelByLedger = $this->sumCancellationsByLedger($ledgers->pluck('id')->all(), $df, $dt);
        $receiptByLedger = $this->sumVouchersByLedger($ledgers->pluck('id')->all(), $df, $dt, [1], 2);
        $paymentByLedger = $this->sumVouchersByLedger($ledgers->pluck('id')->all(), $df, $dt, [2, 3], 1);

        $ledgerIds = $ledgers->pluck('id')->map(fn ($id) => (int) $id)->all();
        $openingBalances = Account::closingBalances(
            $ledgerIds,
            date('Y-m-d', strtotime($df . ' -1 day'))
        );

        $rows = [];
        $totals = [
            'opening_balance' => 0.0,
            'invoice' => 0.0,
            'debit_note' => 0.0,
            'void_refund' => 0.0,
            'bookings' => 0.0,
            'cancellations' => 0.0,
            'receipts' => 0.0,
            'payments' => 0.0,
            'closing_balance' => 0.0,
        ];

        foreach ($ledgers as $ledger) {
            $id = (int) $ledger->id;
            $client = $clientsByAccount->get($id);

            $opening = round((float) ($openingBalances[$id] ?? Account::ob($df, $id)), 2);
            $invoice = round((float) ($invoiceByLedger[$id] ?? 0), 2);
            $debitNote = round((float) ($debitNoteByLedger[$id] ?? 0), 2);
            $voidRefund = round((float) ($refundByLedger[$id] ?? 0), 2);
            $bookings = round((float) ($bookingByLedger[$id] ?? 0), 2);
            $cancellations = round((float) ($cancelByLedger[$id] ?? 0), 2);
            $receipts = round((float) ($receiptByLedger[$id] ?? 0), 2);
            $payments = round((float) ($paymentByLedger[$id] ?? 0), 2);

            // Same reconciliation as attached sample:
            // Closing = Opening + Invoice + DebitNote - Void/Refund + Bookings - Cancellations - Receipts + Payments
            $closing = round(
                $opening + $invoice + $debitNote - $voidRefund + $bookings - $cancellations - $receipts + $payments,
                2
            );

            $hasActivity = abs($opening) > 0.005
                || abs($invoice) > 0.005
                || abs($debitNote) > 0.005
                || abs($voidRefund) > 0.005
                || abs($bookings) > 0.005
                || abs($cancellations) > 0.005
                || abs($receipts) > 0.005
                || abs($payments) > 0.005
                || abs($closing) > 0.005;

            if (!$hasActivity) {
                continue;
            }

            $row = [
                'category' => (string) ($client->category ?? ''),
                'client_account' => $this->formatCode((string) ($ledger->code ?? '')),
                'client_name' => $client->client_name ?? $ledger->Trans_Acc_Name,
                'contact_no' => (string) ($client->mobile ?? ''),
                'opening_balance' => $opening,
                'invoice' => $invoice,
                'debit_note' => $debitNote,
                'void_refund' => $voidRefund,
                'bookings' => $bookings,
                'cancellations' => $cancellations,
                'receipts' => $receipts,
                'payments' => $payments,
                'closing_balance' => $closing,
            ];
            $rows[] = $row;

            foreach (array_keys($totals) as $key) {
                $totals[$key] = round($totals[$key] + (float) $row[$key], 2);
            }
        }

        return [
            'rows' => $rows,
            'totals' => $totals,
            'category_label' => $categoryFilter !== '' ? $categoryFilter : 'All',
            'printed_by' => Auth::user()->name ?? '',
            'opening_label' => date('d/m/Y', strtotime($df)),
            'closing_label' => date('d/m/Y', strtotime($dt)),
            'currency' => 'PKR',
            'currency_name' => 'Pak Rupees',
        ];
    }

    /**
     * Normal sale invoices (ticket/hotel/visa/transport/other) receivable in period.
     *
     * @param  array<int>  $ledgerIds
     * @return array<int, float>
     */
    private function sumInvoiceReceivableByLedger(array $ledgerIds, string $df, string $dt): array
    {
        if (!$ledgerIds) {
            return [];
        }

        $invoices = DB::table('sale_invoices')
            ->whereIn('ledger', $ledgerIds)
            ->whereIn('type', [1, 2, 3, 4, 6])
            ->whereBetween(DB::raw('DATE(inv_date)'), [$df, $dt])
            ->get(['id', 'ledger']);

        return $this->sumReceivableForInvoices($invoices);
    }

    /**
     * Debit notes / UB (tour & misc debit-style invoices).
     *
     * @param  array<int>  $ledgerIds
     * @return array<int, float>
     */
    private function sumDebitNotesByLedger(array $ledgerIds, string $df, string $dt): array
    {
        if (!$ledgerIds) {
            return [];
        }

        $invoices = DB::table('sale_invoices')
            ->whereIn('ledger', $ledgerIds)
            ->whereIn('type', [5])
            ->whereBetween(DB::raw('DATE(inv_date)'), [$df, $dt])
            ->get(['id', 'ledger']);

        return $this->sumReceivableForInvoices($invoices);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, object>  $invoices
     * @return array<int, float>
     */
    private function sumReceivableForInvoices($invoices): array
    {
        if ($invoices->isEmpty()) {
            return [];
        }

        $ids = $invoices->pluck('id')->all();
        $ledgerBySid = $invoices->pluck('ledger', 'id');

        $sidTotals = [];
        foreach (['tickets', 'lead_hotels', 'visas', 'transports', 'other_sales'] as $table) {
            $rows = DB::table($table)
                ->whereIn('SID', $ids)
                ->select('SID', DB::raw('SUM(COALESCE(receiveable, 0)) as amt'))
                ->groupBy('SID')
                ->get();
            foreach ($rows as $row) {
                $sid = (int) $row->SID;
                $sidTotals[$sid] = round(($sidTotals[$sid] ?? 0) + (float) $row->amt, 2);
            }
        }

        // Fallback: debit sale postings when line receiveable is missing for an invoice.
        $missingSids = array_values(array_filter($ids, function ($sid) use ($sidTotals) {
            return !isset($sidTotals[(int) $sid]) || abs($sidTotals[(int) $sid]) < 0.005;
        }));

        if ($missingSids) {
            $posted = DB::table('transactions')
                ->where('status', 1)
                ->where('dr_cr', 1)
                ->whereIn('vt', [4, 5, 6, 7, 8, 10, 11, 12])
                ->whereIn('SID', $missingSids)
                ->select('SID', DB::raw('SUM(amount) as amt'))
                ->groupBy('SID')
                ->get();
            foreach ($posted as $row) {
                $sidTotals[(int) $row->SID] = round((float) $row->amt, 2);
            }
        }

        $amounts = [];
        foreach ($sidTotals as $sid => $amt) {
            $ledger = (int) ($ledgerBySid[$sid] ?? 0);
            if (!$ledger) {
                continue;
            }
            $amounts[$ledger] = round(($amounts[$ledger] ?? 0) + (float) $amt, 2);
        }

        return $amounts;
    }

    /**
     * @param  array<int>  $ledgerIds
     * @return array<int, float>
     */
    private function sumRefundsByLedger(array $ledgerIds, string $df, string $dt): array
    {
        if (!$ledgerIds) {
            return [];
        }

        $map = [];
        $fromTrans = DB::table('transactions')
            ->whereIn('trans_acc_id', $ledgerIds)
            ->where('status', 1)
            ->where('vt', 9)
            ->where('dr_cr', 2)
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->select('trans_acc_id', DB::raw('SUM(amount) as amt'))
            ->groupBy('trans_acc_id')
            ->get();

        foreach ($fromTrans as $row) {
            $map[(int) $row->trans_acc_id] = round((float) $row->amt, 2);
        }

        if (Schema::hasTable('refunds')) {
            $fromTable = DB::table('refunds')
                ->whereIn('client_id', $ledgerIds)
                ->where('status', 1)
                ->when(Schema::hasColumn('refunds', 'refund_date'), function ($q) use ($df, $dt) {
                    $q->whereBetween(DB::raw('DATE(refund_date)'), [$df, $dt]);
                }, function ($q) use ($df, $dt) {
                    $q->whereBetween(DB::raw('DATE(created_at)'), [$df, $dt]);
                })
                ->select('client_id', DB::raw('SUM(COALESCE(net_refund, refund_amount, 0)) as amt'))
                ->groupBy('client_id')
                ->get();

            // Prefer transaction totals when present; otherwise use refunds table.
            foreach ($fromTable as $row) {
                $id = (int) $row->client_id;
                if (!isset($map[$id]) || abs($map[$id]) < 0.005) {
                    $map[$id] = round((float) $row->amt, 2);
                }
            }
        }

        return $map;
    }

    /**
     * Tour/umrah-style bookings (type 5 already counted as debit note in some setups;
     * keep bookings column for future booking modules — currently 0 unless separate booking tables).
     *
     * @param  array<int>  $ledgerIds
     * @return array<int, float>
     */
    private function sumBookingsByLedger(array $ledgerIds, string $df, string $dt): array
    {
        return [];
    }

    /**
     * @param  array<int>  $ledgerIds
     * @return array<int, float>
     */
    private function sumCancellationsByLedger(array $ledgerIds, string $df, string $dt): array
    {
        return [];
    }

    /**
     * @param  array<int>  $ledgerIds
     * @param  array<int>  $vt
     * @return array<int, float>
     */
    private function sumVouchersByLedger(array $ledgerIds, string $df, string $dt, array $vt, int $drCr): array
    {
        if (!$ledgerIds) {
            return [];
        }

        $rows = DB::table('transactions')
            ->whereIn('trans_acc_id', $ledgerIds)
            ->where('status', 1)
            ->whereIn('vt', $vt)
            ->where('dr_cr', $drCr)
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->select('trans_acc_id', DB::raw('SUM(amount) as amt'))
            ->groupBy('trans_acc_id')
            ->get();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row->trans_acc_id] = round((float) $row->amt, 2);
        }

        return $map;
    }

    private function formatCode(string $code): string
    {
        if ($code !== '' && strlen($code) > 4 && strpos($code, '-') === false) {
            return substr($code, 0, 4) . '-' . substr($code, 4);
        }

        return $code;
    }
}
