<?php

namespace App\Http\Controllers\Setup;

use App\Exports\VendorsExport;
use App\Helpers\AccountCodeHelper;
use App\Helpers\LedgerAccountHelper;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vendor_view', ['only' => ['index', 'get_data', 'show', 'exportExcel', 'exportPdf']]);
        $this->middleware('permission:vendor_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vendor_edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:vendor_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setup.vendors.index');
    }

    /**
     * Server-side DataTables source.
     */
    public function get_data(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('vendors')
                ->whereNull('deleted_at')
                ->select(
                    'id',
                    'vendor_code',
                    'vendor_name',
                    'vendor_type',
                    'contact_person',
                    'mobile',
                    'credit_limit',
                    'credit_days',
                    'status'
                );

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('credit_limit', function ($row) {
                    return number_format((float) $row->credit_limit, 2);
                })
                ->addColumn('status_badge', function ($row) {
                    return (int) $row->status === 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $show   = route('vendors.show', $row->id);
                    $edit   = route('vendors.edit', $row->id);
                    $toggle = route('vendors.toggle_status', $row->id);
                    $toggleLabel = (int) $row->status === 1 ? 'Deactivate' : 'Activate';
                    $toggleIcon  = (int) $row->status === 1 ? 'fa-ban' : 'fa-check';

                    $btn  = '<a class="btn btn-info btn-xs" href="'.$show.'" title="View"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a class="btn btn-primary btn-xs" href="'.$edit.'" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="toggle_status(\''.$toggle.'\')" title="'.$toggleLabel.'"><i class="fa '.$toggleIcon.'"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_vendor('.$row->id.')" title="Delete"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types    = Vendor::TYPES;
        $nextCode = AccountCodeHelper::nextTransactionCode(LedgerAccountHelper::vendorGroupId());

        return view('setup.vendors.create', compact('types', 'nextCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateVendor($request);

        DB::beginTransaction();
        try {
            $data['vendor_code'] = $this->nextVendorCode();
            $data['status']      = $request->has('status') ? (int) $request->status : 1;
            $data['created_by']  = Auth::id();

            $vendor = Vendor::create($data);

            $groupId   = LedgerAccountHelper::vendorGroupId();
            $accountId = LedgerAccountHelper::createForReference(
                $groupId,
                $vendor->vendor_name,
                (int) $vendor->id,
                'Vendor',
                (float) $vendor->opening_balance
            );

            $vendor->update(['account_id' => $accountId]);

            DB::commit();

            return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to create vendor: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = Vendor::with(['account', 'creator'])->findOrFail($id);

        return view('setup.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $types  = Vendor::TYPES;

        return view('setup.vendors.edit', compact('vendor', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $data   = $this->validateVendor($request, $vendor->id);

        DB::beginTransaction();
        try {
            $data['status']     = $request->has('status') ? (int) $request->status : 0;
            $data['updated_by'] = Auth::id();

            $vendor->update($data);

            LedgerAccountHelper::syncName($vendor->account_id, $vendor->vendor_name);
            LedgerAccountHelper::setStatus($vendor->account_id, (int) $vendor->status);

            DB::commit();

            return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to update vendor: '.$e->getMessage());
        }
    }

    /**
     * Soft delete the resource and deactivate its ledger account.
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        DB::beginTransaction();
        try {
            LedgerAccountHelper::setStatus($vendor->account_id, 0);
            $vendor->update(['updated_by' => Auth::id()]);
            $vendor->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => 'Vendor deleted successfully.']);
            }

            return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

            return redirect()->back()->with('error', 'Failed to delete vendor: '.$e->getMessage());
        }
    }

    /**
     * Toggle active / inactive status.
     */
    public function toggleStatus($id)
    {
        $vendor    = Vendor::findOrFail($id);
        $newStatus = (int) $vendor->status === 1 ? 0 : 1;

        $vendor->update(['status' => $newStatus, 'updated_by' => Auth::id()]);
        LedgerAccountHelper::setStatus($vendor->account_id, $newStatus);

        if (request()->ajax()) {
            return response()->json(['success' => 'Status updated.', 'status' => $newStatus]);
        }

        return redirect()->route('vendors.index')->with('success', 'Status updated successfully.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VendorsExport($request->get('search')), 'vendors_'.date('Ymd_His').'.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $vendors = Vendor::orderBy('id', 'desc')->get();
        $pdf     = PDF::loadView('setup.vendors.pdf', compact('vendors'))->setPaper('a4', 'landscape');

        return $pdf->download('vendors_'.date('Ymd_His').'.pdf');
    }

    /**
     * Validation rules shared by store / update.
     */
    protected function validateVendor(Request $request, ?int $ignoreVendorId = null): array
    {
        $uniqueName = Rule::unique('vendors', 'vendor_name')
            ->whereNull('deleted_at');

        if ($ignoreVendorId) {
            $uniqueName->ignore($ignoreVendorId);
        }

        $rules = [
            'vendor_name'     => ['required', 'max:255', $uniqueName],
            'vendor_type'     => 'required|in:'.implode(',', Vendor::TYPES),
            'contact_person'  => 'nullable|max:255',
            'email'           => 'nullable|email|max:255',
            'mobile'          => 'required|max:50',
            'phone'           => 'nullable|max:50',
            'city'            => 'nullable|max:100',
            'country'         => 'nullable|max:100',
            'address'         => 'nullable|string',
            'iata_code'       => 'nullable|max:20',
            'airline_code'    => 'nullable|max:20',
            'gst_vat_no'      => 'nullable|max:100',
            'credit_limit'    => 'nullable|numeric',
            'credit_days'     => 'nullable|numeric',
            'opening_balance' => 'nullable|numeric',
            'remarks'         => 'nullable|string',
        ];

        $messages = [
            'vendor_name.required' => 'Vendor Name is required.',
            'vendor_name.unique'   => 'This vendor name already exists. Please use a different name.',
            'vendor_type.required' => 'Vendor Type is required.',
            'mobile.required'      => 'Mobile is required.',
            'email.email'          => 'Please enter a valid email address.',
        ];

        $validated = $request->validate($rules, $messages);

        $validated['credit_limit']    = $validated['credit_limit'] ?? 0;
        $validated['credit_days']     = $validated['credit_days'] ?? 0;
        $validated['opening_balance'] = $validated['opening_balance'] ?? 0;

        return $validated;
    }

    /**
     * Generate the next sequential vendor code (e.g. VN-000001).
     */
    protected function nextVendorCode(): string
    {
        $last = Vendor::withTrashed()->max('id');

        return 'VN-'.str_pad((string) ((int) $last + 1), 6, '0', STR_PAD_LEFT);
    }
}
