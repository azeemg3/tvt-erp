<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

/**
 * BSP (Billing & Settlement Plan) Sale Report.
 *
 * Lists airline ticket sales grouped by branch ("Head Office") together with a
 * separate "Refund" section, and computes branch sub-totals plus an overall net
 * total. The net total nets refunds against sales.
 *
 * Column formula (per row and per total):
 *   Payable = Fare + Taxes - Com + WH + O.Income - Ded
 *
 * Field mapping (tickets):
 *   Fare      = basic_fare
 *   Taxes     = total_taxes (fallback: taxes)
 *   Com       = com_rec
 *   WH        = wh_air
 *   O.Income  = com_paid + pst_paid
 *   Ded       = 0 (no dedicated deduction posted against BSP payable)
 */
class BspSaleReportController extends Controller
{
    /**
     * Column keys that participate in the numeric aggregation.
     */
    private const NUMERIC_COLUMNS = ['fare', 'taxes', 'com', 'wh', 'oincome', 'ded', 'payable'];

    public function index()
    {
        return view('Reports.Sale.bsp_sale_report.index');
    }

    /**
     * Return the grouped report payload (sales, refunds and totals) as JSON.
     */
    public function get_data(Request $request)
    {
        $df = $request->df;
        $dt = $request->dt;
        $airline = $request->airline;

        [$sales, $salesTotals] = $this->buildSection($this->salesRows($df, $dt, $airline));
        [$refunds, $refundTotals] = $this->buildSection($this->refundRows($df, $dt, $airline));

        $netTotals = [];
        foreach (self::NUMERIC_COLUMNS as $column) {
            $netTotals[$column] = round($salesTotals[$column] - $refundTotals[$column], 2);
        }

        return response()->json([
            'branch_label'  => 'Head Office',
            'sales'         => $sales,
            'refunds'       => $refunds,
            'sales_totals'  => $salesTotals,
            'refund_totals' => $refundTotals,
            'net_totals'    => $netTotals,
        ]);
    }

    /**
     * Ticket sales rows for the requested range.
     */
    private function salesRows($df, $dt, $airline)
    {
        return DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->where('sale_invoices.type', 1)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), Account::financial_year())
            ->when($df, function ($query) use ($df, $dt) {
                $query->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$df, $dt]);
            })
            ->when($airline, function ($query) use ($airline) {
                $query->where('tickets.airline', $airline);
            })
            ->select(
                DB::raw("SUBSTRING_INDEX(tickets.ticket_no, '-', 1) as air"),
                'tickets.ticket_no as doc_no',
                'tickets.pax_name',
                'sale_invoices.inv_date as date',
                DB::raw('COALESCE(tickets.basic_fare, 0) as fare'),
                DB::raw('COALESCE(NULLIF(tickets.total_taxes, 0), tickets.taxes, 0) as taxes'),
                DB::raw('COALESCE(tickets.com_rec, 0) as com'),
                DB::raw('COALESCE(tickets.wh_air, 0) as wh'),
                DB::raw('(COALESCE(tickets.com_paid, 0) + COALESCE(tickets.pst_paid, 0)) as oincome'),
                DB::raw('0 as ded')
            )
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('tickets.id')
            ->get();
    }

    /**
     * Ticket refund rows for the requested range.
     */
    private function refundRows($df, $dt, $airline)
    {
        return DB::table('refunds')
            ->where('refunds.refund_to', 1)
            ->whereBetween(DB::raw('DATE(refunds.refund_date)'), Account::financial_year())
            ->when($df, function ($query) use ($df, $dt) {
                $query->whereBetween(DB::raw('DATE(refunds.refund_date)'), [$df, $dt]);
            })
            ->when($airline, function ($query) use ($airline) {
                $query->where('refunds.airline', $airline);
            })
            ->select(
                DB::raw("SUBSTRING_INDEX(refunds.ticket_no, '-', 1) as air"),
                'refunds.ticket_no as doc_no',
                'refunds.pax_name',
                'refunds.refund_date as date',
                DB::raw('COALESCE(refunds.refund_amount, 0) as fare'),
                DB::raw('COALESCE(refunds.refund_taxes, 0) as taxes'),
                DB::raw('COALESCE(refunds.com_rec, 0) as com'),
                DB::raw('COALESCE(refunds.wh_air, 0) as wh'),
                DB::raw('0 as oincome'),
                DB::raw('0 as ded')
            )
            ->orderBy('refunds.refund_date')
            ->orderBy('refunds.id')
            ->get();
    }

    /**
     * Normalise a raw result set into report rows (with computed payable) and
     * their column totals.
     *
     * @return array{0: array<int, array<string, mixed>>, 1: array<string, float>}
     */
    private function buildSection($rows): array
    {
        $data = [];
        $totals = array_fill_keys(self::NUMERIC_COLUMNS, 0.0);

        foreach ($rows as $row) {
            $item = [
                'air'      => $row->air,
                'doc_no'   => $row->doc_no,
                'pax_name' => $row->pax_name,
                'date'     => $row->date,
                'fare'     => (float) $row->fare,
                'taxes'    => (float) $row->taxes,
                'com'      => (float) $row->com,
                'wh'       => (float) $row->wh,
                'oincome'  => (float) $row->oincome,
                'ded'      => (float) $row->ded,
            ];

            $item['payable'] = $item['fare'] + $item['taxes'] - $item['com'] + $item['wh'] + $item['oincome'] - $item['ded'];

            foreach (self::NUMERIC_COLUMNS as $column) {
                $totals[$column] += $item[$column];
            }

            $data[] = $item;
        }

        foreach ($totals as $column => $value) {
            $totals[$column] = round($value, 2);
        }

        return [$data, $totals];
    }
}
