<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lms\Visa;
use DB;
use Auth;
use App\Models\Lms\Lead;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\SaleInvoice;
use App\Helpers\Account;
use Config;
class VisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result=DB::table('sale_invoices')
            ->join('visas','sale_invoices.id', '=','visas.SID')
            ->leftjoin('transaction_accounts', 'sale_invoices.ledger', 'transaction_accounts.id')
            ->select('sale_invoices.*','transaction_accounts.Trans_Acc_Name',
                DB::raw('sum(visas.receiveable) as total'),
                DB::raw('sum(visas.payable) as payable'),
                DB::raw('sum(visas.discount) as discount'),
                DB::raw('sum(visas.profit) as profit'),
                DB::raw('count(visas.id) as totalPax'))->where(['type'=>3])
            ->whereBetween(DB::raw('DATE(visas.created_at)'),Account::financial_year())
            ->when($request->df, function ($query)use ($request){
                $query->whereBetween(DB::raw('DATE(visas.created_at)'), [$request->df, $request->dt]);
            })->when($request->ledger, function ($query)use ($request){
                $query->where('sale_invoices.ledger', $request->ledger);
            })
            ->groupBy('visas.SID')
            ->paginate(15);
        return $result;
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
            'inv_date'=>'required',
            'pax_name'=>'required',
            'receiveable'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'pax_name.required'=>'Pax Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadID','inv_date', 'due_date',
            'payment_type', 'remarks', 'account_code', 'ledger']);
        $sData['type']=3;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $sData['ledger']=$request->ledger;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['amount']=$request->receiveable;
        $tdata['vt']=6;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                $data['trans_code']=Account::trans_code();
                Visa::create($data);
                $tdata['dr_cr']=1;
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.','
                    .'Inv#'.$SID;
                $tdata['trans_acc_id']=$request->ledger;
                $tdata['trans_code']=Account::trans_code();
                Transaction::create($tdata);
                //cr to vendor
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=$request->payable_id;
                $tdata['amount']=$request->payable;
                Transaction::create($tdata);
                //cr to psf
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=Config::get('constant.psf_code');
                $tdata['amount']=$request->psf;
                Transaction::create($tdata);
                //dr to discount allowed
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=Config::get('constant.dis_allowed');
                $tdata['amount']=$request->discount;
                Transaction::create($tdata);
                //cr to agent
                if(isset($request->agent_id)) {
                    $tdata['dr_cr'] = 2;
                    $tdata['trans_acc_id'] = $request->agent_id;
                    $tdata['amount'] = $request->agent_amount;
                    Transaction::create($tdata);
                    //dr to commission expense
                    $tdata['dr_cr'] = 1;
                    $tdata['trans_acc_id'] = Config::get('constant.agent_com_exp');
                    $tdata['amount'] = $request->agent_amount;
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                Visa::where('id', $id)->update($data);
                $tc=Visa::where('id', $id)->value('trans_code');
                Transaction::where('trans_code', $tc)->delete();
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.','
                    .'Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->ledger;
                $tdata['trans_code']=$tc;
                Transaction::create($tdata);
                //cr to vendor
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=$request->payable_id;
                $tdata['amount']=$request->payable;
                Transaction::create($tdata);
                //cr to psf
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=Config::get('constant.psf_code');
                $tdata['amount']=$request->psf;
                Transaction::create($tdata);
                //dr to discount allowed
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=Config::get('constant.dis_allowed');
                $tdata['amount']=$request->discount;
                Transaction::create($tdata);
                //cr to agent
                if(isset($request->agent_id)) {
                    $tdata['dr_cr'] = 2;
                    $tdata['trans_acc_id'] = $request->agent_id;
                    $tdata['amount'] = $request->agent_amount;
                    Transaction::create($tdata);
                    //dr to commission expense
                    $tdata['dr_cr'] = 1;
                    $tdata['trans_acc_id'] = Config::get('constant.agent_com_exp');
                    $tdata['amount'] = $request->agent_amount;
                    Transaction::create($tdata);
                }
                DB::commit();
                return $request->SID;
            }

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
            DB::rollback();
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
        //
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
