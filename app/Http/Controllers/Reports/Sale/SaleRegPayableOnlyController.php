<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SaleRegPayableOnlyController extends Controller
{
    public function index()
    {
        return view('Reports.Sale.sale_reg_payable_only.index');
    }

    public function get_data(Request $request)
    {
        $query = DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->join('transaction_accounts as vendor_acc', 'tickets.payable_id', '=', 'vendor_acc.id')
            ->select(
                'tickets.id',
                'tickets.ticket_no',
                'tickets.ticket_type',
                'tickets.pax_name',
                'tickets.sector',
                'tickets.payable',
                'sale_invoices.inv_date',
                'sale_invoices.id as invoice_id',
                'vendor_acc.Trans_Acc_Name as vendor_name'
            )
            ->where('sale_invoices.type', 1)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), Account::financial_year())
            ->when($request->df, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$request->df, $request->dt]);
            })
            ->when($request->payable_id, function ($q) use ($request) {
                $q->where('tickets.payable_id', $request->payable_id);
            })
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('tickets.id');

        $totals = (clone $query)->select(
            DB::raw('COUNT(tickets.id) as total_count'),
            DB::raw('COALESCE(SUM(tickets.payable), 0) as total_payable')
        )->first();

        $result = $query->paginate(50);
        $data = $result->toArray();
        $data['totals'] = $totals;

        if ($request->payable_id) {
            $data['vendor_name'] = DB::table('transaction_accounts')
                ->where('id', $request->payable_id)
                ->value('Trans_Acc_Name');
        }

        return response()->json($data);
    }
}
