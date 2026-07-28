<?php

namespace App\Http\Controllers\Reports\Sale;

use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SimpleSrModewiseController extends Controller
{
    private const MODES = [
        'ticket'   => ['label' => 'Tickets', 'method' => 'ticketRows'],
        'hotel'    => ['label' => 'Hotels', 'method' => 'hotelRows'],
        'visa'     => ['label' => 'Visa', 'method' => 'visaRows'],
        'transfer' => ['label' => 'Transfers', 'method' => 'transferRows'],
        'other'    => ['label' => 'Other', 'method' => 'otherRows'],
    ];

    public function index()
    {
        return view('Reports.Sale.simple_sr_modewise.index');
    }

    public function get_data(Request $request)
    {
        $mode = $request->mode;
        $modes = ($mode && isset(self::MODES[$mode]))
            ? [$mode => self::MODES[$mode]]
            : self::MODES;

        $sections = [];
        $grandTotals = ['profit' => 0.0, 'receiveable' => 0.0];

        foreach ($modes as $key => $config) {
            $rows = $this->{$config['method']}($request);
            $section = $this->buildSection($rows, $config['label']);
            $sections[] = $section;
            $grandTotals['profit'] += $section['totals']['profit'];
            $grandTotals['receiveable'] += $section['totals']['receiveable'];
        }

        if (count($sections) > 1) {
            $grandTotals['profit'] = round($grandTotals['profit'], 2);
            $grandTotals['receiveable'] = round($grandTotals['receiveable'], 2);
        } else {
            $grandTotals = null;
        }

        return response()->json([
            'sections'    => $sections,
            'grand_total' => $grandTotals,
        ]);
    }

    private function applyDateFilter($query, Request $request, string $dateColumn = 'sale_invoices.inv_date')
    {
        return $query
            ->whereBetween(DB::raw("DATE({$dateColumn})"), Account::financial_year())
            ->when($request->df, function ($q) use ($request, $dateColumn) {
                $q->whereBetween(DB::raw("DATE({$dateColumn})"), [$request->df, $request->dt]);
            });
    }

    private function ticketRows(Request $request)
    {
        return $this->applyDateFilter(
            DB::table('tickets')
                ->join('sale_invoices', 'sale_invoices.id', '=', 'tickets.SID')
                ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
                ->leftJoin('transaction_accounts as vendor_acc', 'tickets.payable_id', '=', 'vendor_acc.id')
                ->where('sale_invoices.type', 1)
                ->select(
                    'sale_invoices.inv_date',
                    'sale_invoices.id as invoice_id',
                    'client_acc.Trans_Acc_Name as client_name',
                    'vendor_acc.Trans_Acc_Name as vendor_name',
                    DB::raw("CONCAT(COALESCE(tickets.sector, ''), ' - ', COALESCE(tickets.pax_name, ''), ' - (', COALESCE(tickets.ticket_no, ''), ')') as description"),
                    DB::raw('COALESCE(tickets.profit, 0) as profit'),
                    DB::raw('COALESCE(tickets.receiveable, 0) as receiveable')
                )
                ->orderBy('sale_invoices.inv_date')
                ->orderBy('tickets.id')
        , $request)->get();
    }

    private function hotelRows(Request $request)
    {
        return $this->applyDateFilter(
            DB::table('lead_hotels')
                ->join('sale_invoices', 'sale_invoices.id', '=', 'lead_hotels.SID')
                ->leftJoin('hotels', 'lead_hotels.hotel', '=', 'hotels.id')
                ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
                ->leftJoin('transaction_accounts as vendor_acc', 'lead_hotels.payable_id', '=', 'vendor_acc.id')
                ->where('sale_invoices.type', 2)
                ->select(
                    'sale_invoices.inv_date',
                    'sale_invoices.id as invoice_id',
                    'client_acc.Trans_Acc_Name as client_name',
                    'vendor_acc.Trans_Acc_Name as vendor_name',
                    DB::raw("CONCAT(COALESCE(hotels.name, ''), ' - ', COALESCE(lead_hotels.pax_name, ''), ' - (', COALESCE(lead_hotels.checkin, ''), ' - ', COALESCE(lead_hotels.checkout, ''), ')') as description"),
                    DB::raw('COALESCE(lead_hotels.profit, 0) as profit'),
                    DB::raw('COALESCE(lead_hotels.receiveable, 0) as receiveable')
                )
                ->orderBy('sale_invoices.inv_date')
                ->orderBy('lead_hotels.id')
        , $request)->get();
    }

    private function visaRows(Request $request)
    {
        return $this->applyDateFilter(
            DB::table('visas')
                ->join('sale_invoices', 'sale_invoices.id', '=', 'visas.SID')
                ->leftJoin('countries', 'visas.visa_country', '=', 'countries.id')
                ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
                ->leftJoin('transaction_accounts as vendor_acc', 'visas.payable_id', '=', 'vendor_acc.id')
                ->where('sale_invoices.type', 3)
                ->select(
                    'sale_invoices.inv_date',
                    'sale_invoices.id as invoice_id',
                    'client_acc.Trans_Acc_Name as client_name',
                    'vendor_acc.Trans_Acc_Name as vendor_name',
                    'visas.pax_name',
                    'visas.visa_type',
                    'countries.name as country_name',
                    DB::raw('COALESCE(visas.profit, 0) as profit'),
                    DB::raw('COALESCE(visas.receiveable, 0) as receiveable')
                )
                ->orderBy('sale_invoices.inv_date')
                ->orderBy('visas.id')
        , $request)->get()
            ->map(function ($row) {
                $visaType = CommonHelper::get_visa_type($row->visa_type) ?: '';
                $row->description = trim(($row->country_name ?: '') . ' - ' . ucfirst($row->pax_name ?: '') . '(' . $visaType . ')');
                unset($row->pax_name, $row->visa_type, $row->country_name);
                return $row;
            });
    }

    private function transferRows(Request $request)
    {
        return $this->applyDateFilter(
            DB::table('transports')
                ->join('sale_invoices', 'sale_invoices.id', '=', 'transports.SID')
                ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
                ->leftJoin('transaction_accounts as vendor_acc', 'transports.payable_id', '=', 'vendor_acc.id')
                ->where('sale_invoices.type', 4)
                ->select(
                    'sale_invoices.inv_date',
                    'sale_invoices.id as invoice_id',
                    'client_acc.Trans_Acc_Name as client_name',
                    'vendor_acc.Trans_Acc_Name as vendor_name',
                    'transports.pax_name',
                    'transports.vehicle_type',
                    'transports.from_date',
                    'transports.to_date',
                    DB::raw('COALESCE(transports.profit, 0) as profit'),
                    DB::raw('COALESCE(transports.receiveable, 0) as receiveable')
                )
                ->orderBy('sale_invoices.inv_date')
                ->orderBy('transports.id')
        , $request)->get()
            ->map(function ($row) {
                $vehicle = $this->vehicleTypeLabel($row->vehicle_type);
                $row->description = trim(ucfirst($vehicle) . ' - ' . ucfirst($row->pax_name ?: '') . ' - ' . ($row->from_date ?: '') . ' to ' . ($row->to_date ?: ''));
                unset($row->pax_name, $row->vehicle_type, $row->from_date, $row->to_date);
                return $row;
            });
    }

    private function otherRows(Request $request)
    {
        return $this->applyDateFilter(
            DB::table('other_sales')
                ->join('sale_invoices', 'sale_invoices.id', '=', 'other_sales.SID')
                ->leftJoin('transaction_accounts as client_acc', 'sale_invoices.ledger', '=', 'client_acc.id')
                ->leftJoin('transaction_accounts as vendor_acc', 'other_sales.payable_id', '=', 'vendor_acc.id')
                ->where('sale_invoices.type', 6)
                ->select(
                    'sale_invoices.inv_date',
                    'sale_invoices.id as invoice_id',
                    'client_acc.Trans_Acc_Name as client_name',
                    'vendor_acc.Trans_Acc_Name as vendor_name',
                    DB::raw('COALESCE(other_sales.pkg_details, \'\') as description'),
                    DB::raw('(COALESCE(other_sales.receiveable, 0) - COALESCE(other_sales.payable, 0)) as profit'),
                    DB::raw('COALESCE(other_sales.receiveable, 0) as receiveable')
                )
                ->orderBy('sale_invoices.inv_date')
                ->orderBy('other_sales.id')
        , $request)->get();
    }

    private function buildSection($rows, string $label): array
    {
        $data = [];
        $totals = ['profit' => 0.0, 'receiveable' => 0.0];

        foreach ($rows as $row) {
            $item = [
                'inv_date'     => $row->inv_date,
                'invoice_id'   => $row->invoice_id,
                'client_name'  => $row->client_name,
                'vendor_name'  => $row->vendor_name,
                'description'  => $row->description,
                'profit'       => (float) $row->profit,
                'receiveable'  => (float) $row->receiveable,
            ];
            $totals['profit'] += $item['profit'];
            $totals['receiveable'] += $item['receiveable'];
            $data[] = $item;
        }

        $totals['profit'] = round($totals['profit'], 2);
        $totals['receiveable'] = round($totals['receiveable'], 2);

        return [
            'label'  => $label,
            'rows'   => $data,
            'totals' => $totals,
        ];
    }

    private function vehicleTypeLabel($id): string
    {
        $types = [
            1 => 'Coaster', 2 => 'Gmc', 3 => 'H1', 4 => 'Limousine', 5 => 'Private Car',
            6 => 'Sedan Car', 7 => 'Sharing Bus', 8 => 'SUV Car', 9 => 'Haramain Train',
        ];

        return $types[$id] ?? '';
    }
}
