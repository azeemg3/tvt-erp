<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Exports\AirlinesExport;
use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class AirlineController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:airline_view', ['only' => ['index', 'get_data', 'show', 'exportExcel', 'exportPdf']]);
        $this->middleware('permission:airline_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:airline_edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:airline_delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view()->first(['Setup.airlines.index', 'setup.airlines.index']);
    }

    public function get_data(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('airlines')
                ->leftJoin('countries', 'airlines.country', '=', 'countries.id')
                ->whereNull('airlines.deleted_at')
                ->select(
                    'airlines.id',
                    'airlines.name',
                    'airlines.iata_code',
                    'airlines.icao_code',
                    'airlines.numeric_code',
                    'airlines.status',
                    'countries.name as country_name'
                );

            return DataTables::of($query)
                ->addIndexColumn()
                ->filterColumn('country_name', function ($q, $keyword) {
                    $q->where('countries.name', 'like', '%'.$keyword.'%');
                })
                ->addColumn('status_badge', function ($row) {
                    return (int) $row->status === 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $show   = route('airlines.show', $row->id);
                    $edit   = route('airlines.edit', $row->id);
                    $toggle = route('airlines.toggle_status', $row->id);
                    $toggleLabel = (int) $row->status === 1 ? 'Deactivate' : 'Activate';
                    $toggleIcon  = (int) $row->status === 1 ? 'fa-ban' : 'fa-check';

                    $btn  = '<a class="btn btn-info btn-xs" href="'.$show.'" title="View"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a class="btn btn-primary btn-xs" href="'.$edit.'" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="toggle_status(\''.$toggle.'\')" title="'.$toggleLabel.'"><i class="fa '.$toggleIcon.'"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_airline('.$row->id.')" title="Delete"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return abort(404);
    }

    public function create()
    {
        return view()->first(['Setup.airlines.create', 'setup.airlines.create']);
    }

    public function store(Request $request)
    {
        $data = $this->validateAirline($request);
        $data['status']     = $request->has('status') ? (int) $request->status : 1;
        $data['created_by'] = Auth::id();

        Airline::create($data);

        return redirect()->route('airlines.index')->with('success', 'Airline created successfully.');
    }

    public function show($id)
    {
        $airline = Airline::with(['creator', 'countryInfo'])->findOrFail($id);

        return view()->first(['Setup.airlines.show', 'setup.airlines.show'], compact('airline'));
    }

    public function edit($id)
    {
        $airline = Airline::findOrFail($id);

        return view()->first(['Setup.airlines.edit', 'setup.airlines.edit'], compact('airline'));
    }

    public function update(Request $request, $id)
    {
        $airline = Airline::findOrFail($id);
        $data    = $this->validateAirline($request, $airline->id);
        $data['status']     = $request->has('status') ? (int) $request->status : 0;
        $data['updated_by'] = Auth::id();

        $airline->update($data);

        return redirect()->route('airlines.index')->with('success', 'Airline updated successfully.');
    }

    public function destroy($id)
    {
        $airline = Airline::findOrFail($id);
        $airline->update(['updated_by' => Auth::id()]);
        $airline->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Airline deleted successfully.']);
        }

        return redirect()->route('airlines.index')->with('success', 'Airline deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $airline   = Airline::findOrFail($id);
        $newStatus = (int) $airline->status === 1 ? 0 : 1;
        $airline->update(['status' => $newStatus, 'updated_by' => Auth::id()]);

        if (request()->ajax()) {
            return response()->json(['success' => 'Status updated.', 'status' => $newStatus]);
        }

        return redirect()->route('airlines.index')->with('success', 'Status updated successfully.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new AirlinesExport($request->get('search')), 'airlines_'.date('Ymd_His').'.xlsx');
    }

    public function exportPdf()
    {
        $airlines = Airline::with('countryInfo')->orderBy('name')->get();
        $pdf      = PDF::loadView('Setup.airlines.pdf', compact('airlines'))->setPaper('a4', 'landscape');

        return $pdf->download('airlines_'.date('Ymd_His').'.pdf');
    }

    protected function validateAirline(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'iata_code'    => $request->filled('iata_code') ? strtoupper(trim($request->iata_code)) : null,
            'icao_code'    => $request->filled('icao_code') ? strtoupper(trim($request->icao_code)) : null,
            'numeric_code' => $request->filled('numeric_code') ? trim($request->numeric_code) : null,
            'country'      => $request->filled('country') ? $request->country : null,
        ]);

        $uniqueName = Rule::unique('airlines', 'name')->whereNull('deleted_at');

        if ($ignoreId) {
            $uniqueName->ignore($ignoreId);
        }

        return $request->validate([
            'name'         => ['required', 'max:191', $uniqueName],
            'iata_code'    => 'nullable|max:3',
            'icao_code'    => 'nullable|max:4',
            'numeric_code' => 'nullable|max:3',
            'country'      => 'nullable|exists:countries,id',
            'remarks'      => 'nullable|string',
        ], [
            'name.required'  => 'Airline name is required.',
            'name.unique'    => 'This airline name already exists.',
            'country.exists' => 'The selected country is invalid.',
        ]);
    }
}
