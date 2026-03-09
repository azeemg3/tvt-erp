<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use App\Models\Lms\LeadHotel;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use DB;
use Auth;
use App\Models\Lms\Lead;
use App\Models\User;
use App\Helpers\Account;
use App\Models\Accounts\Transaction;
class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result=DB::table('sale_invoices')
            ->join('lead_hotels','sale_invoices.id', '=','lead_hotels.SID')
            ->select('sale_invoices.*', DB::raw('sum(lead_hotels.receiveable) as total'),
                DB::raw('count(lead_hotels.id) as totalPax'))->where(['leadID'=>$request->leadID, 'type'=>2])
            ->groupBy('lead_hotels.SID')
            ->paginate(15);
        return $result;
    }
    //@fetch ticket invoice details.......
    public function get_lead_hotel_invDetails($id){
        return LeadHotel::with('hotel')->where('SID', $id)->get();
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
            'payment_type', 'remarks','account_code']);
        $sData['type']=2;
        $sData['leadId']=$request->leadID;
        $sData['inv_date']=$request->inv_date;
        $sData['due_date']=$request->due_date;
        $sData['fourtnite']=$request->fourtnite;
        $sData['payment_type']=$request->payment_type;
        $sData['remarks']=$request->remarks;
        $sData['ledger']=$request->account_code;
        $id=$request->id;
        //create account entry
        $tdata['trans_date']=date('y-m-d');
        $tdata['amount']=$request->receiveable;
        $tdata['vt']=5;
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
                $data['trans_code']=Account::trans_code();
                LeadHotel::create($data);
                $tdata['Created_By']=Auth::user()->id;
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.', Inv#'.$SID;
                $tdata['dr_cr']=1;
                $tdata['trans_acc_id']=$request->account_code;
                $tdata['trans_code']=Account::trans_code();
                Transaction::create($tdata);
                DB::commit();
                return $SID;
            } else {
                $sData['updated_by']=Auth::user()->id;
                SaleInvoice::where('id', $request->SID)->update($sData);
                LeadHotel::where('id', $id)->update($data);
                $tc=LeadHotel::where('id', $id)->value('trans_code');
                $tdata['narration']='('.$request->pax_name.') '.$request->remarks.', Inv#'.$request->SID;
                $tdata['Updated_by']=Auth::user()->id;
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
        $sale=SaleInvoice::find($id);
        $to=Lead::where('id', $sale->leadId)->value('contact_name');
        $enter_by=User::where('id', $sale->created_by)->value('name');
        $result=LeadHotel::with('hotels')->where('SID', $id)->get();
        return view('Lms.sales.prints.hotel',compact('result','sale','to','enter_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return LeadHotel::find($id);
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
