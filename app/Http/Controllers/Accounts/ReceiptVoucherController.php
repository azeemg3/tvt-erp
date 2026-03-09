<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Lms\LeadHotel;
use App\Models\SaleInvoice;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Accounts\ReceiptVoucher;
use App\Models\Accounts\Transaction;
use Auth;
use DB;
use Config;
use PDF;

class ReceiptVoucherController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:rv_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.vouchers.receipt_vouchers.index');
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
            'payment_to'=>'required',
            'payment_type'=>'required',
        ];
        $message=[
            'trans_date.required'=>'Transaction Date Required',
            'payment_to.required'=>'Bank/Cash Account Required',
            'payment_type.required'=>'Payment Type Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','narration','OB','SID']);
        $id=$request->id;
        //account entry
        $tData['trans_date']=$request->trans_date;
        $tData['payment_type']=$request->payment_type;
        $tData['posting_date']=$request->posting_date;
        $tData['payment_to']=$request->payment_to;
        $tData['payment_from']=$request->payment_from;
        $tData['narration']=$request->narration;
        $tData['amount']=$request->amount;
        $tData['status']=1;
        $tData['vt']=1;
        $tData['SID']=$request->SID;
        if(isset($request->attach_file)) {
            $photo=$request->attach_file;
            $docFile=url('/storage/app/'.$photo->store('public/vouchers/receipt_voucher'));
            $data['attach_file']=$docFile;
        }
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['trans_code']=Account::trans_code();
                $data['Created_by']=Auth::user()->id;
                $data['remarks']=$request->narration;
                $ret=ReceiptVoucher::create($data);
                $tData['Parent_Type']=$ret->id;
                $tData['Created_By']=Auth::user()->id;
                //dr to cash bank
                $tData['trans_code']=Account::trans_code();
                $tData['trans_acc_id']=$request->payment_to;
                $tData['dr_cr']=1;
                Transaction::create($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=2;
                Transaction::create($tData);
            } else {
                $data['Updated_by']=Auth::user()->id;
                $data['remarks']=$request->narration;
                ReceiptVoucher::where('trans_code', $id)->update($data);
                Transaction::where('trans_code', $id)->delete();
                $tData['Created_By']=Auth::user()->id;
                //dr to cash bank
                $tData['trans_code']=$id;
                $tData['trans_acc_id']=$request->payment_to;
                $tData['dr_cr']=1;
                Transaction::create($tData);
                //cr to client
                $tData['trans_acc_id']=$request->payment_from;
                $tData['dr_cr']=2;
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
        }
        return response()->json(['success' => 'Added new record Successfully.']);
    }
    //@listing data
    public function get_data(Request $request){
        return ReceiptVoucher::whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->paginate(15);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result=DB::table('receipt_vouchers')
            ->join('transactions','receipt_vouchers.trans_code','transactions.trans_code')
        ->join('transaction_accounts','transactions.trans_acc_id','transaction_accounts.id')
            ->select('*','receipt_vouchers.id AS RID')
        ->where(['receipt_vouchers.trans_code'=>$id,'dr_cr'=>2])->get();
        $data=compact('result');
//        dd($data);
        view()->share('data', $data);
        $pdf= PDF::loadView('Accounts.vouchers.receipt_vouchers.show', $data);
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=DB::table('receipt_vouchers')
            ->join('transactions','receipt_vouchers.trans_code','transactions.trans_code')
            ->select('*', 'transactions.SID AS invID')
            ->where(['receipt_vouchers.trans_code'=>$id])->first();
        return response()->json($result);
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
        ReceiptVoucher::where('trans_code', $id)->delete();
        Transaction::where('trans_code', $id)->delete();
    }
    //@fetch invoices against client id
    public function fetch_client_inv($id){
        return SaleInvoice::where('ledger', $id)->get('id');
    }
    //fethc balance against invoice id
    public function fetch_inv_balance($id){
        $client_id=SaleInvoice::find($id);
        $ticket=Ticket::where('SID', $id)->get(['trans_code'])->toArray();
        $hotels=LeadHotel::where('SID', $id)->get(['trans_code'])->toArray();
        $ids=array_merge($ticket,$hotels);
        $total=Transaction::where('trans_acc_id',$client_id->ledger)->whereIn('trans_code',$ids)->whereIn('vt', [4,5,6,7,8,10,11])->sum('amount');
        $receipt=Transaction::where(['SID'=>$id, 'trans_acc_id'=>$client_id->ledger])->whereIn('vt', [1])->sum('amount');
        $bal=($total)-($receipt);
        return $bal;
    }
}
