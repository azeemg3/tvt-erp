<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use App\Models\Accounts\Transaction;
use App\Models\Crm\Agent;
use Illuminate\Http\Request;
use DB;
use App\Models\Agent\AgentWallet;
use Auth;
use App\Helpers\Account;

class AgentWalletController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:wallet_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.agent_wallet.index');
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
            'trans_date'=>'required',
            'payment_from'=>'required',
            'agentID'=>'required',
            'amount'=>'required',
            'narration'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'payment_from.required'=>'Bank/Cash Required',
            'agentID.required'=>'Agent Required',
            'narration.required'=>'Narration Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token']);
        $id=$request->id;
        //account entry
        $payment_to=TransactionAccount::where('PID',21)
            ->where('Parent_Type',$request->agentID)->first();
        $tData['trans_date']=$request->trans_date;
        $tData['posting_date']=$request->posting_date;
        $tData['narration']=$request->narration;
        $tData['amount']=$request->amount;
        $tData['status']=1;
        $tData['vt']=1;
        $tData['trans_code']=Account::trans_code();
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $data['trans_code']=Account::trans_code();
                $ret=AgentWallet::create($data);
                $tData['Created_By']=Auth::user()->id;
                $tData['trans_acc_id']=$payment_to->id;
                $tData['dr_cr']=2;
                Transaction::create($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=1;
                Transaction::create($tData);
            }
            else
            {
                $data['created_by']=Auth::user()->id;
                $data['status']=1;
                $data['trans_code']=Account::trans_code();
                AgentWallet::where('id', $id)->update($data);
                $tData['Created_By']=Auth::user()->id;
                $tData['trans_acc_id']=$payment_to->id;
                $tData['dr_cr']=2;
                Transaction::create($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=1;
                Transaction::create($tData);
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
        return response()->json(['success' => 'Added new record Successfully.']);
    }
    //dispaly data in list
    public function get_data(){
        return AgentWallet::with(['agent', 'pf'])
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->orderBy('id','DESC')->paginate(50);
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
        return AgentWallet::find($id);
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
