<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\TransportAgentPrice;
use App\Models\TransportValidity;
use Illuminate\Http\Request;
use App\Models\TransportRate;
use DB;
use App\Models\Accounts\Agent;

class TransportRateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transport_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Rate_setup.transport_rate.index');
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
            'source'=>'required',
            'transport_type'=>'required',
            'purchase'=>'required',
            'agent'=>'required',
            'markup_type'=>'required',
            'markup_value'=>'required',
            'month'=>'required',
        ];
        $message=[
            'from_city.required'=>'From City Required',
            'to_city.required'=>'To City Required',
            'source.required'=>'Source Required',
            'transport_type.required'=>'Transport Type Required',
            'purchase.required'=>'Purchase Required',
            'markup_type.required'=>'Markup Type Required',
            'markup_value.required'=>'Markup Value Required',
            'month.required'=>'Month Required',
        ];
        $this->validate($request,$rules,$message);
        $data['from_city']=$request->from_city;
        $data['to_city']=$request->to_city;
        $data['source']=$request->source;
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
        $count=count($request->agent);
        $count_tr=count($request->validity_date_rate);
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=TransportRate::create($data);
                for($i=0; $i<$count; $i++){
                    $agentData['agent']=$request->agent[$i];
                    $agentData['markup_type']=$request->markup_type;
                    $agentData['markup_value']=$request->markup_value;
                    $agentData['from_city']=$request->from_city;
                    $agentData['to_city']=$request->to_city;
                    $agentData['transport_type']=$request->transport_type;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    $agentData['TRID']=$ret->id;
                    TransportAgentPrice::create($agentData);
                }
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
                for($i=0; $i<$count; $i++){
                    $agentData['agent']=$request->agent[$i];
                    $agentData['markup_type']=$request->markup_type;
                    $agentData['markup_value']=$request->markup_value;
                    $agentData['from_city']=$request->from_city;
                    $agentData['to_city']=$request->to_city;
                    $agentData['transport_type']=$request->transport_type;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    $agentData['TRID']=$id;
                    TransportAgentPrice::create($agentData);
                }
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
        return TransportRate::with(['fromCity','toCity','source','transport_agents'])
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
        $res=TransportRate::find($id);
        $agents=TransportAgentPrice::where('TRID', $id)->get();
        return compact('res','agents');
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
        return TransportRate::destroy($id);
    }
    /*
     * approved hotel rate when service provider sent request for approval
     */
    public function approve_transport_rate($id){
        return TransportRate::where('id',$id)->update(['status'=>1]);
    }
}
