<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\GeneralAccount;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneralAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general_account_view', ['only' => ['index', 'get_data']]);
        $this->middleware('permission:general_account_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:general_account_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:general_account_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Setup.general_accounts.index');
    }

    /**
     * Server-side DataTables source.
     */
    public function get_data(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('general_accounts')
                ->whereNull('deleted_at')
                ->select(
                    'id',
                    'name',
                    'nic',
                    'city',
                    'phone',
                    'is_spo',
                    'is_ro',
                    'is_marketing_officer'
                );

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('role_badges', function ($row) {
                    $badges = '';
                    if ((int) $row->is_spo === 1) {
                        $badges .= '<span class="badge badge-info mr-1">SPO</span>';
                    }
                    if ((int) $row->is_ro === 1) {
                        $badges .= '<span class="badge badge-primary mr-1">RO</span>';
                    }
                    if ((int) $row->is_marketing_officer === 1) {
                        $badges .= '<span class="badge badge-success mr-1">Marketing Officer</span>';
                    }

                    return $badges ?: '<span class="text-muted">—</span>';
                })
                ->addColumn('action', function ($row) {
                    $edit = route('general-accounts.edit', $row->id);

                    $btn  = '<a class="btn btn-primary btn-xs" href="'.$edit.'" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_general_account('.$row->id.')" title="Delete"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['role_badges', 'action'])
                ->make(true);
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Setup.general_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateGeneralAccount($request);

        DB::beginTransaction();
        try {
            $data['created_by'] = Auth::id();

            GeneralAccount::create($data);

            DB::commit();

            return redirect()->route('general-accounts.index')->with('success', 'General Account created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to create general account: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $generalAccount = GeneralAccount::findOrFail($id);

        return view('Setup.general_accounts.edit', compact('generalAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $generalAccount = GeneralAccount::findOrFail($id);
        $data           = $this->validateGeneralAccount($request);

        DB::beginTransaction();
        try {
            $data['updated_by'] = Auth::id();

            $generalAccount->update($data);

            DB::commit();

            return redirect()->route('general-accounts.index')->with('success', 'General Account updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to update general account: '.$e->getMessage());
        }
    }

    /**
     * Soft delete the resource.
     */
    public function destroy($id)
    {
        $generalAccount = GeneralAccount::findOrFail($id);

        DB::beginTransaction();
        try {
            $generalAccount->update(['updated_by' => Auth::id()]);
            $generalAccount->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => 'General Account deleted successfully.']);
            }

            return redirect()->route('general-accounts.index')->with('success', 'General Account deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

            return redirect()->back()->with('error', 'Failed to delete general account: '.$e->getMessage());
        }
    }

    /**
     * Validation rules shared by store / update.
     */
    protected function validateGeneralAccount(Request $request): array
    {
        $rules = [
            'name'    => 'required|max:255',
            'nic'     => ['nullable', 'max:20', 'regex:/^(\d{5}-\d{7}-\d|\d{13})?$/'],
            'address' => 'nullable|string',
            'city'    => 'nullable|max:100',
            'phone'   => ['required', 'max:50', 'regex:/^[0-9+\-\s()]{7,20}$/'],
        ];

        $messages = [
            'name.required'  => 'Name is required.',
            'phone.required' => 'Phone is required.',
            'phone.regex'    => 'Please enter a valid phone number.',
            'nic.regex'      => 'NIC must be 13 digits or in the format 12345-1234567-1.',
        ];

        $validated = $request->validate($rules, $messages);

        $validated['is_spo']               = $request->boolean('is_spo');
        $validated['is_ro']                = $request->boolean('is_ro');
        $validated['is_marketing_officer'] = $request->boolean('is_marketing_officer');

        return $validated;
    }
}
