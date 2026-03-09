<?php

namespace App\Http\Controllers\Providors;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\Agent;
use App\Models\Accounts\ServiceProvidor;
use App\Models\Crm\HotelRate;
use App\Models\HotelAgentPrice;
use App\Models\HotelsRate;
use App\Models\HotelVailidty;
use Illuminate\Http\Request;
use Auth;
use App\Models\Accounts\TransactionAccount;
use DB;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('providors.hotels.index');
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
            'net_purchase'=>'required',
            'room_type'=>'required',
            'month'=>'required',
        ];
        $message=[
            'city_id.required'=>'City Required',
            'hotel_id.required'=>'Hotel Name Required',
            'net_purchase.required'=>'Purchase Required',
            'room_type.required'=>'Room Type Required',
            'month.required'=>'Month Required',
        ];
        $this->validate($request,$rules,$message);
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        $data['source']=$source_id;
        $data['city_id']=$request->city_id;
        $data['hotel_id']=$request->hotel_id;
        $data['contact']=$request->contact;
        $data['room_type']=$request->room_type;
        $data['purchase']=$request->purchase;
        $data['sale_tax']=$request->sale_tax;
        $data['vat']=$request->vat;
        $data['wh']=$request->wh;
        $data['oc']=$request->oc;
        $data['net_purchase']=$request->net_purchase;
        $data['month']=$request->month;
        $count_vr=count($request->validity_date_rate);
        DB::beginTransaction();
        try
        {
            $ret=HotelsRate::create($data);
            //count validity rate
            $agentData['agent']=0;
            $agentData['markup_type']=0;
            $agentData['markup_value']=0;
            $agentData['room_type']=$request->room_type;
            $agentData['hotel_id']=$request->hotel_id;
            $agentData['HRID']=$ret->id;
            $agentData['month']=$request->month;
            $agentData['validity_date_rate']=json_encode($request->validity_date_rate);
            HotelAgentPrice::create($agentData);
            for($j=1; $j<=$count_vr; $j++){
                $today=($j);
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
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }
        catch (\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            return response()->json([
                'status' => 'false',
                'errors'  => $e->getMessage(),
            ], 400);
            DB::rollBack();
        }
    }
    //@display data in list
    public function get_data(Request $request){
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        $result= HotelsRate::with(['city','hotel','rt'])
            ->where('source',$source_id)
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
            return $result;
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
