<?php

namespace App\Http\Controllers\Providors;

use App\Http\Controllers\Controller;
use App\Models\Accounts\ServiceProvidor;
use App\Models\Accounts\TransactionAccount;
use App\Models\TransportAgentPrice;
use App\Models\TransportRate;
use App\Models\TransportValidity;
use Auth;
use DB;
use App\Helpers\Account;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('providors.transports.index');
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
            'from_city'=>'required',
            'to_city'=>'required',
            'transport_type'=>'required',
            'purchase'=>'required',
            'month'=>'required',
        ];
        $message=[
            'from_city.required'=>'From City Required',
            'to_city.required'=>'To City Required',
            'transport_type.required'=>'Transport Type Required',
            'purchase.required'=>'Purchase Required',
            'month.required'=>'Month Required',
        ];
        $this->validate($request,$rules,$message);
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        $data['source']=$source_id;
        $data['from_city']=$request->from_city;
        $data['to_city']=$request->to_city;
        $data['contact_number']=$request->contact_number;
        $data['currency_id']=$request->currency_id;
        $data['currency_rate']=$request->currency_rate;
        $data['transport_type']=$request->transport_type;
        $data['purchase']=$request->purchase;
        $data['sale_tax']=$request->sale_tax;
        $data['vat']=$request->vat;
        $data['wh']=$request->wh;
        $data['oc']=$request->oc;
        $data['net_purchase']=$request->net_purchase;
        $id=$request->id;
        $count_tr=count($request->validity_date_rate);
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=TransportRate::create($data);
                    $agentData['agent']=0;
                    $agentData['markup_type']=0;
                    $agentData['markup_value']=0;
                    $agentData['from_city']=$request->from_city;
                    $agentData['to_city']=$request->to_city;
                    $agentData['transport_type']=$request->transport_type;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    $agentData['TRID']=$ret->id;
                    TransportAgentPrice::create($agentData);
                for($j=1; $j<=$count_tr; $j++){
                    $cd=date('Y-'.$request->month.'-'.$j);
                    $arr[]=array('validity_date'=>$cd, 'month'=>$request->month,
                        'rate'=>$request->validity_date_rate[$j],
                        'TRID'=>$ret->id);
                }
                TransportValidity::insert($arr);
                TransportValidity::where('validity_date', '0000-00-00');
            }else{
                TransportRate::where('id',$id)->update($data);
                TransportAgentPrice::where('TRID', $id)->delete();
                TransportValidity::where('TRID', $id)->delete();
                    $agentData['agent']=0;
                    $agentData['markup_type']=0;
                    $agentData['markup_value']=0;
                    $agentData['from_city']=$request->from_city;
                    $agentData['to_city']=$request->to_city;
                    $agentData['transport_type']=$request->transport_type;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    $agentData['TRID']=$id;
                    TransportAgentPrice::create($agentData);
                for($j=1; $j<=$count_tr; $j++){
                    $cd=date('Y-'.$request->month.'-'.$j);
                    $arr[]=array('validity_date'=>$cd, 'month'=>$request->month,
                        'rate'=>$request->validity_date_rate[$j],
                        'TRID'=>$id);
                }
                TransportValidity::insert($arr);
                TransportValidity::where('validity_date', '0000-00-00')->delete();
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }catch (QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
        }
    }
    //@display data in list
    public function get_data(Request $request){
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        return TransportRate::with(['fromCity','toCity','source','transport_agents'])
            ->where('source', $source_id)
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->when($request->from_city, function ($query) use ($request){
                $query->where('from_city', $request->from_city);
            })->when($request->transport_type, function ($query) use ($request){
                $query->where('transport_type', $request->transport_type);
            })->when($request->vendor, function ($query) use ($request){
                $query->where('source', $request->vendor);
            })
            ->orderByDesc('id')->paginate(15);
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
