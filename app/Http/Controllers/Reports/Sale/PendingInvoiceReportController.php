<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingInvoiceReportController extends Controller
{
    public function index()
    {
        return view('Reports.Sale.pending_invoice_report.index');
    }

    public function get_data(Request $request)
    {
        $isClearanceReport = $request->boolean('clearance');

        $ticketBill = DB::table('tickets')
            ->select('SID', DB::raw('COALESCE(SUM(receiveable), 0) as amount'), DB::raw('GROUP_CONCAT(DISTINCT pax_name SEPARATOR ", ") as pax_names'))
            ->groupBy('SID');

        $hotelBill = DB::table('lead_hotels')
            ->select('SID', DB::raw('COALESCE(SUM(receiveable), 0) as amount'), DB::raw('GROUP_CONCAT(DISTINCT pax_name SEPARATOR ", ") as pax_names'))
            ->groupBy('SID');

        $visaBill = DB::table('visas')
            ->select('SID', DB::raw('COALESCE(SUM(receiveable), 0) as amount'), DB::raw('GROUP_CONCAT(DISTINCT pax_name SEPARATOR ", ") as pax_names'))
            ->groupBy('SID');

        $transportBill = DB::table('transports')
            ->select('SID', DB::raw('COALESCE(SUM(receiveable), 0) as amount'), DB::raw('GROUP_CONCAT(DISTINCT pax_name SEPARATOR ", ") as pax_names'))
            ->groupBy('SID');

        $otherBill = DB::table('other_sales')
            ->select('SID', DB::raw('COALESCE(SUM(receiveable), 0) as amount'), DB::raw('GROUP_CONCAT(DISTINCT pax_name SEPARATOR ", ") as pax_names'))
            ->groupBy('SID');

        $paidSub = DB::table('transactions')
            ->select('SID', 'trans_acc_id', DB::raw('COALESCE(SUM(amount), 0) as paid_amount'))
            ->where('vt', 1)
            ->whereNotNull('SID')
            ->groupBy('SID', 'trans_acc_id');

        $rows = DB::table('sale_invoices as si')
            ->leftJoin('transaction_accounts as client_acc', 'si.ledger', '=', 'client_acc.id')
            ->leftJoinSub($ticketBill, 'tb', 'tb.SID', '=', 'si.id')
            ->leftJoinSub($hotelBill, 'hb', 'hb.SID', '=', 'si.id')
            ->leftJoinSub($visaBill, 'vb', 'vb.SID', '=', 'si.id')
            ->leftJoinSub($transportBill, 'trb', 'trb.SID', '=', 'si.id')
            ->leftJoinSub($otherBill, 'ob', 'ob.SID', '=', 'si.id')
            ->leftJoinSub($paidSub, 'paid', function ($join) {
                $join->on('paid.SID', '=', 'si.id')
                    ->on('paid.trans_acc_id', '=', 'si.ledger');
            })
            ->select(
                'si.id as invoice_no',
                'si.inv_date',
                'si.ledger',
                'client_acc.Trans_Acc_Name as client_name',
                DB::raw('(COALESCE(tb.amount, 0) + COALESCE(hb.amount, 0) + COALESCE(vb.amount, 0) + COALESCE(trb.amount, 0) + COALESCE(ob.amount, 0)) as bill_amount'),
                DB::raw('COALESCE(paid.paid_amount, 0) as paid_amount'),
                DB::raw("TRIM(BOTH ', ' FROM CONCAT_WS(', ',
                    NULLIF(tb.pax_names, ''),
                    NULLIF(hb.pax_names, ''),
                    NULLIF(vb.pax_names, ''),
                    NULLIF(trb.pax_names, ''),
                    NULLIF(ob.pax_names, '')
                )) as passenger_name")
            )
            ->whereBetween(DB::raw('DATE(si.inv_date)'), Account::financial_year())
            ->when($request->df, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(si.inv_date)'), [$request->df, $request->dt]);
            })
            ->when($request->ledger, function ($q) use ($request) {
                $q->where('si.ledger', $request->ledger);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('si.type', $request->type);
            })
            ->when($isClearanceReport, function ($q) {
                $q->havingRaw('bill_amount > 0 AND paid_amount >= bill_amount');
            }, function ($q) {
                $q->havingRaw('(bill_amount - paid_amount) > 0');
            })
            ->orderBy('client_acc.Trans_Acc_Name')
            ->orderBy('si.inv_date')
            ->orderBy('si.id')
            ->get();

        $groups = [];
        $grand = [
            'bill_amount' => 0.0,
            'paid_amount' => 0.0,
            'balance' => 0.0,
            'count' => 0,
        ];

        foreach ($rows as $row) {
            $client = $row->client_name ?: 'Unknown Client';
            $bill = (float) $row->bill_amount;
            $paid = (float) $row->paid_amount;
            $balance = round($bill - $paid, 2);

            if (!isset($groups[$client])) {
                $groups[$client] = [
                    'client_name' => $client,
                    'rows' => [],
                    'totals' => [
                        'bill_amount' => 0.0,
                        'paid_amount' => 0.0,
                        'balance' => 0.0,
                        'count' => 0,
                    ],
                ];
            }

            $item = [
                'invoice_no' => $row->invoice_no,
                'inv_date' => $row->inv_date,
                'passenger_name' => $row->passenger_name ?: '',
                'bill_amount' => round($bill, 2),
                'paid_amount' => round($paid, 2),
                'balance' => $balance,
            ];

            $groups[$client]['rows'][] = $item;
            $groups[$client]['totals']['bill_amount'] += $item['bill_amount'];
            $groups[$client]['totals']['paid_amount'] += $item['paid_amount'];
            $groups[$client]['totals']['balance'] += $item['balance'];
            $groups[$client]['totals']['count']++;

            $grand['bill_amount'] += $item['bill_amount'];
            $grand['paid_amount'] += $item['paid_amount'];
            $grand['balance'] += $item['balance'];
            $grand['count']++;
        }

        foreach ($groups as &$group) {
            foreach (['bill_amount', 'paid_amount', 'balance'] as $key) {
                $group['totals'][$key] = round($group['totals'][$key], 2);
            }
        }
        unset($group);

        foreach (['bill_amount', 'paid_amount', 'balance'] as $key) {
            $grand[$key] = round($grand[$key], 2);
        }

        return response()->json([
            'groups' => array_values($groups),
            'grand_totals' => $grand,
        ]);
    }
}
