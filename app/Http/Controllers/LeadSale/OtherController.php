<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Lms\OtherSale;
use DB;
use Auth;
use App\Models\Lms\Lead;
use App\Helpers\Account;
use App\Models\Accounts\Transaction;

class OtherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result=DB::table('sale_invoices')
            ->join('other_sales','sale_invoices.id', '=','other_sales.SID')
            ->select('sale_invoices.*', DB::raw('sum(other_sales.receiveable) as total'),
                DB::raw('count(other_sales.id) as totalPax'))->where(['sale_invoices.leadID'=>$request->leadID,
                'sale_invoices.type'=>6])
            ->groupBy('other_sales.SID')->paginate(15);
        return $result;
    }
    //@ohter sale detials
    public function get_lead_other_invDetails($id){
        return OtherSale::where('SID', $id)->get();
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
            'receiveable.required'=>'Receiveable Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadId','inv_date', 'due_date',
            'payment_type', 'remarks','trans_code']);
        $sData['type']=5;
        $sData['leadId']=$request->leadId;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['amount']=$request->receiveable;
        $tdata['vt']=4;
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
                OtherSale::create($data);
                $tdata['Created_By']=Auth::user()->id;
                $tdata['dr_cr']=1;
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.' Inv#'.$SID;
                $tdata['trans_acc_id']=$request->account_code;
                $tdata['trans_code']=Account::trans_code();
                Transaction::create($tdata);
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                OtherSale::where('id', $id)->update($data);
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
        return OtherSale::find($id);
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
