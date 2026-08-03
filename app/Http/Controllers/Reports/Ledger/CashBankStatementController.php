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
 * Cash & Bank Statement for a selected bank/cash ledger account.
 *
 * Lists receipt debits and payment credits, period totals, and balance summary.
 */
class CashBankStatementController extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Ledger.cash_bank_statement.index');
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
            return response()->json(['message' => 'Bank / cash account not found.'], 422);
        }

        $openingBalance = Account::ob($df, $ledgerId);
        $receiptLines = $this->collectReceiptLines($ledgerId, $df, $dt);
        $paymentLines = $this->collectPaymentLines($ledgerId, $df, $dt);

        $receiptTotal = collect($receiptLines)->sum('debit');
        $paymentTotal = collect($paymentLines)->sum('credit');
        $closingBalance = $openingBalance + $receiptTotal - $paymentTotal;
        $netPeriodCredit = $receiptTotal - $paymentTotal;

        return response()->json([
            'ledger_name' => $ledger->Trans_Acc_Name,
            'receipts' => $receiptLines,
            'receipt_total' => round($receiptTotal, 2),
            'payments' => $paymentLines,
            'payment_total' => round($paymentTotal, 2),
            'period_total_debit' => round($receiptTotal, 2),
            'period_total_credit' => round($paymentTotal, 2),
            'summary' => [
                'opening_balance_label' => Account::show_bal($openingBalance),
                'receipts_label' => number_format($receiptTotal, 2) . ' Dr',
                'payments_label' => number_format($paymentTotal, 2) . ' Dr',
                'vouchers_debit_total_label' => Account::show_bal($openingBalance + $receiptTotal + $paymentTotal),
                'net_credit_label' => '(' . number_format(abs($netPeriodCredit), 2) . ') Cr',
                'closing_balance_label' => Account::show_bal($closingBalance),
            ],
        ]);
    }

    /**
     * Receipt-side bank movements (money in): RV debit plus transfer-in PV debit.
     */
    private function collectReceiptLines(int $ledgerId, string $df, string $dt): array
    {
        $lines = [];

        $bankReceipts = DB::table('transactions as t')
            ->leftJoin('receipt_vouchers as rv', function ($join) {
                $join->on('rv.payment_to', '=', 't.trans_acc_id')
                    ->on('rv.trans_date', '=', 't.trans_date')
                    ->on('rv.amount', '=', 't.amount');
            })
            ->where('t.trans_acc_id', $ledgerId)
            ->where('t.status', 1)
            ->where('t.dr_cr', 1)
            ->whereIn('t.vt', [1, 2])
            ->whereBetween(DB::raw('DATE(t.trans_date)'), [$df, $dt])
            ->orderBy('t.trans_date')
            ->orderBy('t.trans_code')
            ->orderBy('t.id')
            ->select('t.*', 'rv.payment_type as rv_payment_type', 'rv.cheque as rv_cheque')
            ->get();

        foreach ($bankReceipts as $row) {
            $expanded = $this->expandReceiptRow($row);
            foreach ($expanded as $line) {
                $lines[] = $line;
            }
        }

        return $lines;
    }

    /**
     * When one receipt voucher splits across multiple client credits, show one bank line per allocation.
     */
    private function expandReceiptRow(object $bankRow): array
    {
        if ((int) $bankRow->vt !== 1) {
            return [$this->mapMovementRow($bankRow, 'debit')];
        }

        $credits = DB::table('transactions')
            ->where('trans_code', $bankRow->trans_code)
            ->where('vt', 1)
            ->where('dr_cr', 2)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        if ($credits->count() <= 1) {
            return [$this->mapMovementRow($bankRow, 'debit')];
        }

        $lines = [];
        foreach ($credits as $credit) {
            $clone = clone $bankRow;
            $clone->amount = $credit->amount;
            $clone->narration = $credit->narration ?: $bankRow->narration;
            if (empty($clone->rv_payment_type) && !empty($credit->payment_type)) {
                $clone->rv_payment_type = $credit->payment_type;
            }
            $lines[] = $this->mapMovementRow($clone, 'debit');
        }

        return $lines;
    }

    /**
     * Payment-side bank movements (money out): PV credit on this account.
     */
    private function collectPaymentLines(int $ledgerId, string $df, string $dt): array
    {
        return DB::table('transactions')
            ->where('trans_acc_id', $ledgerId)
            ->where('status', 1)
            ->where('vt', 2)
            ->where('dr_cr', 2)
            ->whereBetween(DB::raw('DATE(trans_date)'), [$df, $dt])
            ->orderBy('trans_date')
            ->orderBy('trans_code')
            ->get()
            ->map(fn ($row) => $this->mapMovementRow($row, 'credit'))
            ->values()
            ->all();
    }

    private function mapMovementRow(object $row, string $side): array
    {
        $amount = (float) $row->amount;
        $isDebit = $side === 'debit';

        $paymentType = $row->rv_payment_type ?? $row->payment_type ?? null;
        $cheque = $row->rv_cheque ?? null;

        return [
            'voucher_date' => $row->trans_date,
            'v_id' => CommonHelper::dsn($row->trans_code),
            'ticket_chq_ref' => $this->paymentTypeRef($paymentType, $cheque),
            'details' => $row->narration ?? '',
            'debit' => $isDebit ? round($amount, 2) : 0.0,
            'credit' => $isDebit ? 0.0 : round($amount, 2),
        ];
    }

    private function paymentTypeRef($paymentType, $cheque): string
    {
        $map = [1 => 'CASH', 2 => 'CHEQUE', 3 => 'ONLINE', 4 => 'CREDIT'];
        $type = (int) $paymentType;
        if ($type === 2 && !empty($cheque)) {
            return strtoupper($cheque);
        }

        return $map[$type] ?? 'CASH';
    }
}
