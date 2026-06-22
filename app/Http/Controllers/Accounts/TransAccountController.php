<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\AccountCodeHelper;
use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use DataTables;
use Illuminate\Http\Request;
use DB;

class TransAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.trans_accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'PID'=>'required',
            'Trans_Acc_Name' => 'required|unique:transaction_accounts,Trans_Acc_Name',
        ];
        $message=[
            'PID.required'=>'A/C Type Required',
            'Trans_Acc_Name.required'=>'Trans Account Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'password', 'roles']);
        $data['editable']=1;
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['code'] = AccountCodeHelper::nextTransactionCode((int) $request->PID);
                TransactionAccount::create($data);
            } else {
                unset($data['code']);
                TransactionAccount::where('id', $id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            DB::rollBack();
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
        }
    }

    public function nextCode(Request $request)
    {
        $request->validate(['PID' => 'required|exists:sub_head_accounts,id']);

        return response()->json([
            'code' => AccountCodeHelper::nextTransactionCode((int) $request->PID),
        ]);
    }

    //listing data (DataTables server-side)
    public function get_data(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('transaction_accounts')
                ->leftJoin('sub_head_accounts', 'transaction_accounts.PID', '=', 'sub_head_accounts.id')
                ->select(
                    'transaction_accounts.id',
                    'transaction_accounts.code',
                    'transaction_accounts.Trans_Acc_Name',
                    'sub_head_accounts.name as subhead_name'
                )
                ->orderBy('transaction_accounts.code');

            return DataTables::of($query)
                ->addIndexColumn()
                ->orderColumn('subhead_name', 'sub_head_accounts.name $1')
                ->filterColumn('subhead_name', function ($query, $keyword) {
                    $query->where('sub_head_accounts.name', 'like', '%'.$keyword.'%');
                })
                ->addColumn('balance', function () {
                    return '0.00';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = url('Accounts/trans_accounts/'.$row->id);
                    $btn = '<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('.$row->id.')"><i class="fa fa-edit"></i></a>';
                    $btn .= ' <a class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''.$row->id.'\', \''.$deleteUrl.'\')"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return TransactionAccount::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
