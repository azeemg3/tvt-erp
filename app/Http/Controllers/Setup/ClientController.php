<?php

namespace App\Http\Controllers\Setup;

use App\Exports\ClientsExport;
use App\Helpers\AccountCodeHelper;
use App\Helpers\LedgerAccountHelper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\GeneralAccount;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:client_view', ['only' => ['index', 'get_data', 'show', 'exportExcel', 'exportPdf']]);
        $this->middleware('permission:client_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client_edit', ['only' => ['edit', 'update', 'toggleStatus']]);
        $this->middleware('permission:client_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setup.clients.index');
    }

    /**
     * Server-side DataTables source.
     */
    public function get_data(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('clients')
                ->leftJoin('general_accounts', 'clients.ro_id', '=', 'general_accounts.id')
                ->whereNull('clients.deleted_at')
                ->select(
                    'clients.id',
                    'clients.client_code',
                    'clients.client_name',
                    'clients.mobile',
                    'clients.email',
                    'clients.category',
                    'clients.credit_limit',
                    'clients.status',
                    'general_accounts.name as recovery_officer'
                );

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('credit_limit', function ($row) {
                    return number_format((float) $row->credit_limit, 2);
                })
                ->filterColumn('recovery_officer', function ($q, $keyword) {
                    $q->where('general_accounts.name', 'like', '%'.$keyword.'%');
                })
                ->addColumn('status_badge', function ($row) {
                    return (int) $row->status === 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-secondary">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $show   = route('clients.show', $row->id);
                    $edit   = route('clients.edit', $row->id);
                    $toggle = route('clients.toggle_status', $row->id);
                    $toggleLabel = (int) $row->status === 1 ? 'Deactivate' : 'Activate';
                    $toggleIcon  = (int) $row->status === 1 ? 'fa-ban' : 'fa-check';

                    $btn  = '<a class="btn btn-info btn-xs" href="'.$show.'" title="View"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a class="btn btn-primary btn-xs" href="'.$edit.'" title="Edit"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a class="btn btn-warning btn-xs" href="javascript:void(0)" onclick="toggle_status(\''.$toggle.'\')" title="'.$toggleLabel.'"><i class="fa '.$toggleIcon.'"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_client('.$row->id.')" title="Delete"><i class="fa fa-trash"></i></a>';

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
        $categories   = Client::CATEGORIES;
        $nextCode     = AccountCodeHelper::nextTransactionCode(LedgerAccountHelper::clientGroupId());

        [$spos, $recoveryOfficers, $marketingOfficers] = $this->generalAccountOptions();

        return view('setup.clients.create', compact(
            'categories',
            'nextCode',
            'spos',
            'recoveryOfficers',
            'marketingOfficers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateClient($request);

        DB::beginTransaction();
        try {
            $data['client_code'] = $this->nextClientCode();
            $data['status']      = $request->has('status') ? (int) $request->status : 1;
            $data['created_by']  = Auth::id();

            $client = Client::create($data);

            $groupId   = LedgerAccountHelper::clientGroupId();
            $accountId = LedgerAccountHelper::createForReference(
                $groupId,
                $client->client_name,
                (int) $client->id,
                'Client'
            );

            $client->update(['account_id' => $accountId]);

            DB::commit();

            return redirect()->route('clients.index')->with('success', 'Client created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to create client: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with([
            'account',
            'creator',
            'spoAccount',
            'recoveryOfficerAccount',
            'marketingOfficerAccount',
        ])->findOrFail($id);

        return view('setup.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client     = Client::findOrFail($id);
        $categories = Client::CATEGORIES;

        [$spos, $recoveryOfficers, $marketingOfficers] = $this->generalAccountOptions();

        return view('setup.clients.edit', compact(
            'client',
            'categories',
            'spos',
            'recoveryOfficers',
            'marketingOfficers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $data   = $this->validateClient($request);

        DB::beginTransaction();
        try {
            $data['status']     = $request->has('status') ? (int) $request->status : 0;
            $data['updated_by'] = Auth::id();

            $client->update($data);

            // Keep the linked ledger account name in sync.
            LedgerAccountHelper::syncName($client->account_id, $client->client_name);
            LedgerAccountHelper::setStatus($client->account_id, (int) $client->status);

            DB::commit();

            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Failed to update client: '.$e->getMessage());
        }
    }

    /**
     * Soft delete the resource and deactivate its ledger account.
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        DB::beginTransaction();
        try {
            LedgerAccountHelper::setStatus($client->account_id, 0);
            $client->update(['updated_by' => Auth::id()]);
            $client->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => 'Client deleted successfully.']);
            }

            return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (request()->ajax()) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

            return redirect()->back()->with('error', 'Failed to delete client: '.$e->getMessage());
        }
    }

    /**
     * Toggle active / inactive status.
     */
    public function toggleStatus($id)
    {
        $client    = Client::findOrFail($id);
        $newStatus = (int) $client->status === 1 ? 0 : 1;

        $client->update(['status' => $newStatus, 'updated_by' => Auth::id()]);
        LedgerAccountHelper::setStatus($client->account_id, $newStatus);

        if (request()->ajax()) {
            return response()->json(['success' => 'Status updated.', 'status' => $newStatus]);
        }

        return redirect()->route('clients.index')->with('success', 'Status updated successfully.');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ClientsExport($request->get('search')), 'clients_'.date('Ymd_His').'.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $clients = Client::with(['spoAccount', 'recoveryOfficerAccount', 'marketingOfficerAccount'])->orderBy('id', 'desc')->get();
        $pdf     = PDF::loadView('setup.clients.pdf', compact('clients'))->setPaper('a4', 'landscape');

        return $pdf->download('clients_'.date('Ymd_His').'.pdf');
    }

    /**
     * Validation rules shared by store / update.
     */
    protected function validateClient(Request $request): array
    {
        $rules = [
            'client_name'         => 'required|max:255',
            'email'               => 'nullable|email|max:255',
            'mobile'               => 'required|max:50',
            'co_spo'               => 'nullable|max:255',
            'spo_id'               => 'required|exists:general_accounts,id',
            'ro_id'                => 'nullable|exists:general_accounts,id',
            'marketing_officer_id' => 'nullable|exists:general_accounts,id',
            'category'             => 'required|in:'.implode(',', Client::CATEGORIES),
            'credit_limit'        => 'nullable|numeric',
            'credit_days'         => 'nullable|numeric',
            'address'             => 'nullable|string',
            'remarks'             => 'nullable|string',
        ];

        $messages = [
            'client_name.required'      => 'Client Name is required.',
            'mobile.required'           => 'Client Mobile is required.',
            'category.required'         => 'Category is required.',
            'email.email'               => 'Please enter a valid email address.',
            'spo_id.required'           => 'SPO is required.',
            'spo_id.exists'             => 'The selected SPO is invalid.',
            'ro_id.exists'              => 'The selected Recovery Officer is invalid.',
            'marketing_officer_id.exists' => 'The selected Marketing Officer is invalid.',
        ];

        $validated = $request->validate($rules, $messages);

        $this->assertGeneralAccountDesignation($validated['spo_id'], 'is_spo', 'SPO', 'spo_id');
        if (! empty($validated['ro_id'])) {
            $this->assertGeneralAccountDesignation($validated['ro_id'], 'is_ro', 'Recovery Officer', 'ro_id');
        }
        if (! empty($validated['marketing_officer_id'])) {
            $this->assertGeneralAccountDesignation($validated['marketing_officer_id'], 'is_marketing_officer', 'Marketing Officer', 'marketing_officer_id');
        }

        $validated['credit_limit'] = $validated['credit_limit'] ?? 0;
        $validated['credit_days']  = $validated['credit_days'] ?? 0;

        return $validated;
    }

    /**
     * Generate the next sequential client code (e.g. CL-000001).
     */
    protected function nextClientCode(): string
    {
        $last = Client::withTrashed()->max('id');

        return 'CL-'.str_pad((string) ((int) $last + 1), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Build the three General Account dropdown collections, each filtered by its designation flag.
     *
     * @return array{0:\Illuminate\Support\Collection,1:\Illuminate\Support\Collection,2:\Illuminate\Support\Collection}
     */
    protected function generalAccountOptions(): array
    {
        $columns = ['id', 'name', 'nic', 'city'];

        $spos = GeneralAccount::where('is_spo', true)
            ->orderBy('name')
            ->get($columns);

        $recoveryOfficers = GeneralAccount::where('is_ro', true)
            ->orderBy('name')
            ->get($columns);

        $marketingOfficers = GeneralAccount::where('is_marketing_officer', true)
            ->orderBy('name')
            ->get($columns);

        return [$spos, $recoveryOfficers, $marketingOfficers];
    }

    /**
     * Ensure the selected General Account has the expected designation flag.
     */
    protected function assertGeneralAccountDesignation(int $id, string $flag, string $label, string $field): void
    {
        $account = GeneralAccount::find($id);

        if (! $account || ! $account->{$flag}) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => "The selected {$label} is not valid.",
            ]);
        }
    }
}
