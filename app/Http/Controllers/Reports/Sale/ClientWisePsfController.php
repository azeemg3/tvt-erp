<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reports\ParsesReportDates;
use Illuminate\Http\Request;
use DB;
use InvalidArgumentException;

class ClientWisePsfController extends Controller
{
    use ParsesReportDates;

    public function index()
    {
        return view('Reports.Sale.client_wise_psf.index');
    }

    public function get_data(Request $request)
    {
        try {
            $this->mergeParsedReportDates($request);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $query = DB::table('tickets')
            ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
            ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
            ->where('sale_invoices.type', 1)
            ->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), Account::financial_year())
            ->when($request->df, function ($q) use ($request) {
                $q->whereBetween(DB::raw('DATE(sale_invoices.inv_date)'), [$request->df, $request->dt]);
            })
            ->when($request->ledger, function ($q) use ($request) {
                $q->where('sale_invoices.ledger', $request->ledger);
            })
            ->select(
                'sale_invoices.ledger as client_id',
                'client_acc.Trans_Acc_Name as client_name',
                'sale_invoices.inv_date',
                'sale_invoices.id as invoice_id',
                'tickets.ticket_no',
                'tickets.pax_name',
                'tickets.sector',
                DB::raw('COALESCE(tickets.basic_fare, 0) as fare'),
                DB::raw('COALESCE(tickets.psf, 0) as psf'),
                DB::raw('COALESCE(tickets.receiveable, 0) as receiveable')
            )
            ->orderBy('client_acc.Trans_Acc_Name')
            ->orderBy('sale_invoices.inv_date')
            ->orderBy('tickets.id')
            ->get();

        $sections = [];
        $grandTotals = ['fare' => 0.0, 'psf' => 0.0, 'receiveable' => 0.0];
        $currentClientId = null;
        $currentSection = null;

        foreach ($query as $row) {
            $fare = (float) $row->fare;
            $psf = (float) $row->psf;
            $psfp = $fare > 0 ? round(($psf / $fare) * 100, 2) : 0;

            $item = [
                'inv_date'    => $row->inv_date,
                'invoice_id'  => $row->invoice_id,
                'ticket_no'   => $row->ticket_no,
                'pax_name'    => $row->pax_name,
                'sector'      => $row->sector,
                'fare'        => $fare,
                'psf'         => $psf,
                'psfp'        => $psfp,
                'receiveable' => (float) $row->receiveable,
            ];

            if ($currentClientId !== $row->client_id) {
                if ($currentSection !== null) {
                    $sections[] = $currentSection;
                }
                $currentClientId = $row->client_id;
                $currentSection = [
                    'label'  => $row->client_name ?: 'Unknown Client',
                    'rows'   => [],
                    'totals' => ['fare' => 0.0, 'psf' => 0.0, 'receiveable' => 0.0],
                ];
            }

            $currentSection['rows'][] = $item;
            $currentSection['totals']['fare'] += $item['fare'];
            $currentSection['totals']['psf'] += $item['psf'];
            $currentSection['totals']['receiveable'] += $item['receiveable'];

            $grandTotals['fare'] += $item['fare'];
            $grandTotals['psf'] += $item['psf'];
            $grandTotals['receiveable'] += $item['receiveable'];
        }

        if ($currentSection !== null) {
            $sections[] = $currentSection;
        }

        foreach ($sections as &$section) {
            $section['totals']['fare'] = round($section['totals']['fare'], 2);
            $section['totals']['psf'] = round($section['totals']['psf'], 2);
            $section['totals']['receiveable'] = round($section['totals']['receiveable'], 2);
        }
        unset($section);

        $grandTotals['fare'] = round($grandTotals['fare'], 2);
        $grandTotals['psf'] = round($grandTotals['psf'], 2);
        $grandTotals['receiveable'] = round($grandTotals['receiveable'], 2);

        return response()->json([
            'sections'    => $sections,
            'grand_total' => $grandTotals,
        ]);
    }
}
