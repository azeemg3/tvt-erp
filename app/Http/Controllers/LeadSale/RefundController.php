<?php

namespace App\Http\Controllers\LeadSale;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lms\Refund;
use DB;
use Auth;
use PHPUnit\TextUI\Help;
use App\Models\Accounts\Transaction;
use App\Helpers\Account;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Refund::where('leadId', $request->leadID)->paginate(15);
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
            'refund_amount'=>'required',
            'refund_date'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'pax_name.required'=>'Pax Name Required',
            'refund_amount.required'=>'Refund Amount Required',
            'refund_date.required'=>'Refund Date Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','payment_type','account_code']);
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['amount']=$request->refund_amount+$request->service_charges;
        $tdata['vt']=8;
        $tdata['narration']=CommonHelper::get_sale_type($request->refund_to).' Refund ('.$request->pax_name.') '.$request->remarks;
        $tdata['status']=0;
        $tdata['payment_type']=$request->payment_type;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $data['trans_code']=Account::trans_code();
                Refund::create($data);
                $tdata['Created_By']=Auth::user()->id;
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=$request->account_code;
                $tdata['trans_code']=Account::trans_code();
                Transaction::create($tdata);
            } else {
                Refund::where('id', $id)->update($data);
                $trans_code=Refund::where('id', $id)->value('trans_code');
                $tdata['Update_by']=Auth::user()->id;
                $tdata['dr_cr']=2;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $trans_code)->update($tdata);
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $code,
            ], 400);
        }
        return response()->json(['success' => 'Added new record Successfully.']);
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
        return Refund::find($id);
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
