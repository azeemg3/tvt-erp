<?php

namespace App\Http\Controllers\ApplicationSetup;
use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelAgentPrice;
use App\Models\HotelVailidty;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\HotelsRate;
use DB;
use App\Models\Accounts\Agent;

class HotelRateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:hotel_rate_list_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Rate_setup.hotel_rate.index');
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
            'city_id'=>'required',
            'hotel_id'=>'required',
            'source'=>'required',
            'net_purchase'=>'required',
            'agent'=>'required',
            'room_type'=>'required',
            'month'=>'required',
        ];
        $message=[
            'city_id.required'=>'City Required',
            'hotel_id.required'=>'Hotel Name Required',
            'source.required'=>'Source Required',
            'net_purchase.required'=>'Purchase Required',
            'agent.required'=>'Agent Required',
            'room_type.required'=>'Room Type Required',
            'month.required'=>'Month Required',
        ];
        $this->validate($request,$rules,$message);
        $data['city_id']=$request->city_id;
        $data['hotel_id']=$request->hotel_id;
        $data['contact']=$request->contact;
        $data['currency_id']=$request->currency_id;
        $data['currency_rate']=$request->currency_rate;
        $data['source']=$request->source;
        $data['room_type']=$request->room_type;
        $data['purchase']=$request->purchase;
        $data['sale_tax']=$request->sale_tax;
        $data['vat']=$request->vat;
        $data['wh']=$request->wh;
        $data['oc']=$request->oc;
        $data['net_purchase']=$request->net_purchase;
        $id=$request->id;
        $count=count($request->agent);
        $count_vr=count($request->validity_date_rate);
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=HotelsRate::create($data);
                for($i=0; $i<$count; $i++){
                    $agentData['agent']=$request['agent'][$i];
                    $agentData['markup_type']=$request['markup_type'];
                    $agentData['markup_value']=$request['markup_value'];
                    $agentData['room_type']=$request->room_type;
                    $agentData['hotel_id']=$request->hotel_id;
                    $agentData['HRID']=$ret->id;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    HotelAgentPrice::create($agentData);
                }
                //count validity rate
                for($j=1; $j<=$count_vr; $j++){
                    $today=($j) + (1);
                    $cd=date('Y-'.$request->month.'-'.$today);
                    $arr[]=array(
                        'validity_date'=>$cd,
                        'month'=>$request->month,
                        'rate'=>$request->validity_date_rate[$j],
                        'HRID'=>$ret->id
                    );
                }
                HotelVailidty::insert($arr);
                HotelVailidty::where('validity_date', '0000-00-00')->delete();
            }else{
                $status=HotelsRate::find($id)->status;
               if($status==0){
                   return response()->json([
                       'errors'=>3,
                   ], 400);
               }
                HotelsRate::where('id',$id)->update($data);
                HotelAgentPrice::where('HRID', $id)->delete();
                HotelVailidty::where('HRID', $id)->delete();
                for($i=0; $i<$count; $i++){
                    $agentData['agent']=$request['agent'][$i];
                    $agentData['markup_type']=$request['markup_type'];
                    $agentData['markup_value']=$request['markup_value'];
                    $agentData['hotel_id']=$request->hotel_id;
                    $agentData['room_type']=$request->room_type;
                    $agentData['HRID']=$id;
                    $agentData['month']=$request->month;
                    $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
                    HotelAgentPrice::create($agentData);
                }
                //count validity rate
                for($j=1; $j<=$count_vr; $j++){
                    $today=($j);
                    $cd=date('Y-'.$request->month.'-'.$today);
                    $arr[]=array(
                        'validity_date'=>$cd,
                        'month'=>$request->month,
                        'rate'=>$request->validity_date_rate[$j],
                        'HRID'=>$id
                    );
                }
                HotelVailidty::insert($arr);
                HotelVailidty::where('validity_date', '0000-00-00')->delete();
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
        return HotelsRate::with(['city','hotel','source', 'rt','hotel_agents'])
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->when($request->city, function($query)use ($request){
                  $query->where('city_id', $request->city);
            })->when($request->room_type, function($query)use ($request){
                  $query->where('room_type', $request->room_type);
            })->when($request->hotel_id, function ($query)use ($request){
                $query->where('hotel_id', $request->hotel_id);
            })->when($request->source, function ($query) use ($request){
                $query->where('source',$request->vendor);
            })
            ->orderBy('id','DESC')->paginate(15);

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
        $res=HotelsRate::find($id);
        $agents=HotelAgentPrice::where('HRID', $id)->get();
        $hotel_vailidties=HotelVailidty::where('HRID',$id)->get();
        return compact('res','agents','hotel_vailidties');
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
        HotelAgentPrice::where('HRID', $id)->delete();
        HotelVailidty::where('HRID', $id)->delete();
        HotelsRate::destroy($id);
    }
    /*
     * approved hotel rate when service provider sent request for approval
     */
    public function approve_hotel_rate($id){
        return HotelsRate::where('id',$id)->update(['status'=>1]);
    }
}
