<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lms\PcrTest;
use App\Models\Accounts\Transaction;
use DB;
use Auth;
use App\Models\SaleInvoice;
use App\Helpers\Account;
use Config;

class PcrController extends Controller
{
    public function index(Request $request){
        $result=DB::table('sale_invoices')
            ->join('pcr_tests','sale_invoices.id', '=','pcr_tests.SID')
            ->select('sale_invoices.*', DB::raw('sum(pcr_tests.receiveable) as total'),
                DB::raw('count(pcr_tests.id) as totalPax'))->where(['leadID'=>$request->leadID, 'type'=>10])
            ->groupBy('pcr_tests.SID')
            ->paginate(15);
        return $result;
    }
    //@invouce recoreds
    public function get_lead_pcr_invDetails($id){
        return PcrTest::with('airline')->where('SID', $id)->get();
    }

    public function store(Request $request){
        $rules=[
            'inv_date'=>'required',
            'pax_name'=>'required',
            'receiveable'=>'required',
            'airline_id'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'pax_name.required'=>'Pax Name Required',
            'receiveable.required'=>'Receiveable Required',
            'airline_id.required'=>'Airline Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadId','inv_date', 'due_date',
            'payment_type', 'remarks','trans_code','account_code']);
        $sData['type']=10;
        $sData['leadId']=$request->leadId;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $sData['ledger']=$request->account_code;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['amount']=$request->receiveable;
        $tdata['vt']=11;
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
                PcrTest::create($data);
                $tdata['Created_By']=Auth::user()->id;
                $tdata['dr_cr']=1;
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.' Inv#'.$SID;
                $tdata['trans_acc_id']=$request->account_code;
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
                $tdata['amount']=($request->receiveable)-($request->payable);
                Transaction::create($tdata);
                //dr to discount allowed
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=Config::get('constant.dis_allowed');
                $tdata['amount']=$request->discount;
                Transaction::create($tdata);
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                PcrTest::where('id', $id)->update($data);
                $tc=PcrTest::where('id', $id)->value('trans_code');
                Transaction::where('trans_code', $tc)->delete();
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['dr_cr']=1;
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.' Inv#'.$request->SID;
                $tdata['trans_acc_id']=$request->account_code;
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
                $tdata['amount']=($request->receiveable)-($request->payable);
                Transaction::create($tdata);
                //dr to discount allowed
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=Config::get('constant.dis_allowed');
                $tdata['amount']=$request->discount;
                Transaction::create($tdata);
                DB::commit();
                return $request->SID;
            }

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //@edit record
    public function edit($id){
        return PcrTest::find($id);
    }
}
