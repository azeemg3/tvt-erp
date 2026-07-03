<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SimpleSaleRegisterController extends Controller
{
    public function index()
    {
        return view('Reports.Sale.simple_sale_register.index');
    }

    public function get_data(Request $request)
    {
        $query = DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
            ->leftJoin('transaction_accounts as vendor_acc', 'tickets.payable_id', '=', 'vendor_acc.id')
            ->select(
                'tickets.id',
                'tickets.ticket_no',
                'tickets.ticket_type',
                'tickets.pax_name',
                'tickets.sector',
                'tickets.receiveable',
                'tickets.payable',
                'tickets.profit',
                'sale_invoices.inv_date',
                'sale_invoices.id as invoice_id',
                'client_acc.Trans_Acc_Name as client_name',
                'vendor_acc.Trans_Acc_Name as vendor_name'
            )
            ->where('sale_invoices.type', 1)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), Account::financial_year())
            ->when($request->df, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$request->df, $request->dt]);
            })
            ->when($request->ledger, function ($q) use ($request) {
                $q->where('sale_invoices.ledger', $request->ledger);
            })
            ->when($request->payable_id, function ($q) use ($request) {
                $q->where('tickets.payable_id', $request->payable_id);
            })
            ->orderBy('sale_invoices.inv_date', 'desc')
            ->orderBy('tickets.id', 'desc');

        $totals = (clone $query)->select(
            DB::raw('COUNT(tickets.id) as total_count'),
            DB::raw('COALESCE(SUM(tickets.receiveable), 0) as total_receivable'),
            DB::raw('COALESCE(SUM(tickets.payable), 0) as total_payable'),
            DB::raw('COALESCE(SUM(tickets.profit), 0) as total_profit')
        )->first();

        $result = $query->paginate(50);
        $data = $result->toArray();
        $data['totals'] = $totals;

        return response()->json($data);
    }
}
