<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
use App\Models\SaleInvoice;
use App\Models\Ticket;
use App\Models\Lms\LeadHotel;
use App\Models\Lms\Visa;
use App\Models\Lms\Transport;
use App\Models\Lms\OtherSale;
use App\Models\Lms\Lead;
use App\Models\Accounts\Transaction;
use App\Helpers\Account;
class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result=DB::table('sale_invoices')
            ->leftjoin('tickets','sale_invoices.id', '=','tickets.SID')
            ->select('sale_invoices.*', DB::raw('sum(tickets.receiveable) as total'),
                DB::raw('count(tickets.id) as totalPax'))->where(['leadID'=>$request->leadID, 'type'=>5])
            ->groupBy('sale_invoices.id')
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
        //
    }
    //@sotre tour tickets
    public function ticket_store(Request $request){
        $rules=[
            'inv_date'=>'required',
            'pax_name'=>'required',
            'sector'=>'required',
            'departure_date'=>'required',
            'ticket_no'=>'required',
            'basic_fare'=>'required',
            'receiveable'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'pax_name.required'=>'Pax Name Required',
            'sector.required'=>'sector Required',
            'departure_date.required'=>'Departure Date Required',
            'ticket_no.required'=>'Ticket No Required',
            'basic_fare.required'=>'Basic Fare Required',
            'receiveable.required'=>'Receiveable Fare Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadID','inv_date', 'due_date','fourtnite',
            'payment_type', 'remarks', 'pax_name', 'account_code']);
        $count=count($request->pax_name);
        $sData['type']=6;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['fourtnite']=$request->fourtnite;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['vt']=4;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    Lead::change_lead_status($request->leadID, 2);
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                for($i=0; $i<$count; $i++){
                    $data['pax_name']=$request['pax_name'][$i];
                    $data['trans_code']=Account::trans_code();
                    Ticket::create($data);
                    $tdata['narration']='('.$request['pax_name'][$i].') '.$request->remarks.', Inv#'.$SID;
                    $tdata['amount']=$request->receiveable;
                    $tdata['Created_By']=Auth::user()->id;
                    $tdata['dr_cr']=1;
                    $tdata['trans_acc_id']=$request->account_code;
                    $tdata['trans_code']=Account::trans_code();
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                $data['pax_name']=$request['pax_name'][0];
                Ticket::where('id', $id)->update($data);
                $tc=Ticket::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request['pax_name'][0].') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['amount']=$request->receiveable;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $tc)->update($tdata);
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
    //@store tour hotel details
    public function hotel_store(Request $request){
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
            'payment_type', 'remarks','pax_name', 'account_code']);
        $sData['type']=6;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['fourtnite']=$request->fourtnite;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $count=count($request->pax_name);
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['vt']=4;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    Lead::change_lead_status($request->leadID, 2);
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                for($i=0; $i<$count; $i++){
                    $data['pax_name']=$request['pax_name'][$i];
                    $data['trans_code']=Account::trans_code();
                    LeadHotel::create($data);
                    $tdata['narration']='('.$request['pax_name'][$i].') '.$request->remarks.', Inv#'.$SID;
                    $tdata['amount']=$request->receiveable;
                    $tdata['Created_By']=Auth::user()->id;
                    $tdata['dr_cr']=1;
                    $tdata['trans_acc_id']=$request->account_code;
                    $tdata['trans_code']=Account::trans_code();
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                $data['pax_name']=$request['pax_name'][0];
                LeadHotel::where('id', $id)->update($data);
                $tc=LeadHotel::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request['pax_name'][0].') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['amount']=$request->receiveable;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $tc)->update($tdata);
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
    //@store visa detials
    public function visa_store(Request $request){
        $rules=[
            'inv_date'=>'required',
            'receiveable'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'receiveable.required'=>'Receiveable Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadID','inv_date', 'due_date',
            'payment_type', 'remarks', 'pax_name','account_code']);
        $sData['type']=6;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $count=count($request->pax_name);
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['vt']=6;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    Lead::change_lead_status($request->leadID, 2);
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                for($i=0; $i<$count; $i++){
                    $data['pax_name']=$request['pax_name'][$i];
                    $data['trans_code']=Account::trans_code();
                    Visa::create($data);
                    $tdata['narration']='('.$request['pax_name'][$i].') '.$request->remarks.', Inv#'.$SID;
                    $tdata['amount']=$request->receiveable;
                    $tdata['Created_By']=Auth::user()->id;
                    $tdata['dr_cr']=1;
                    $tdata['trans_acc_id']=$request->account_code;
                    $tdata['trans_code']=Account::trans_code();
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                $data['pax_name']=$request['pax_name'][0];
                Visa::where('id', $id)->update($data);
                $tc=Visa::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request['pax_name'][0].') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['amount']=$request->receiveable;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $tc)->update($tdata);
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
    //@store tour transport
    public function transport_store(Request $request){
        $rules=[
            'inv_date'=>'required',
            'receiveable'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'receiveable.required'=>'Receiveable Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadID','inv_date', 'due_date',
            'payment_type', 'remarks', 'pax_name','account_code']);
        $sData['type']=6;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['vt']=4;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        $count=count($request->pax_name);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    Lead::change_lead_status($request->leadID, 2);
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                for($i=0; $i<$count; $i++){
                    $data['pax_name']=$request['pax_name'][$i];
                    $data['trans_code']=Account::trans_code();
                    Transport::create($data);
                    $tdata['narration']='('.$request['pax_name'][$i].') '.$request->remarks.', Inv#'.$SID;
                    $tdata['amount']=$request->receiveable;
                    $tdata['Created_By']=Auth::user()->id;
                    $tdata['dr_cr']=1;
                    $tdata['trans_acc_id']=$request->account_code;
                    $tdata['trans_code']=Account::trans_code();
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                $data['pax_name']=$request['pax_name'][0];
                Transport::where('id', $id)->update($data);
                $tc=Transport::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request['pax_name'][0].') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['amount']=$request->receiveable;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $tc)->update($tdata);
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
    //@store tour ohter sale
    public function other_store(Request $request){
        $rules=[
            'inv_date'=>'required',
            'receiveable'=>'required',
        ];
        $message=[
            'inv_date.required'=>'Invoice Date Required',
            'receiveable.required'=>'Receiveable Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'type','leadID','inv_date', 'due_date',
            'payment_type', 'remarks', 'pax_name','account_code']);
        $sData['type']=5;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['vt']=10;
        $tdata['status']=1;
        $tdata['payment_type']=$request->payment_type;
        $count=count($request->pax_name);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                if($id==0 && $request->SID==0) {
                    Lead::change_lead_status($request->leadID, 2);
                    $ret = SaleInvoice::create($sData);
                    $data['SID'] = $ret->id;
                    $SID=$ret->id;
                }else{
                    $data['SID']=$request->SID;
                    $SID=$request->SID;
                }
                for($i=0; $i<$count; $i++){
                    $data['trans_code']=Account::trans_code();
                    $data['pax_name']=$request['pax_name'][$i];
                    $data['trans_code']=Account::trans_code();
                    OtherSale::create($data);
                    $tdata['narration']='('.$request['pax_name'][$i].') '.$request->remarks.', Inv#'.$SID;
                    $tdata['amount']=$request->receiveable;
                    $tdata['Created_By']=Auth::user()->id;
                    $tdata['dr_cr']=1;
                    $tdata['trans_acc_id']=$request->account_code;
                    $tdata['trans_code']=Account::trans_code();
                    $tdata['amount']=$request->receiveable;
                    Transaction::create($tdata);
                }
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                $data['pax_name']=$request['pax_name'][0];
                OtherSale::where('id', $id)->update($data);
                $tc=OtherSale::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request['pax_name'][0].') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
                $tdata['amount']=$request->receiveable;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                Transaction::where('trans_code', $tc)->update($tdata);
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

    //@tour pax save in session
    public function tour_pax(Request $request){
        $request->validate([
            "pax_name.*"  => "required",
        ]);
        $data=$request->all();
        Session::put('pax_data', $data);
        return Session::get('pax_data');
    }
}
