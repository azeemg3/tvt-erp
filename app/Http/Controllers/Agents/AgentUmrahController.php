<?php

namespace App\Http\Controllers\Agents;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Http\Controllers\Controller;
use App\Mail\UmrahVouhcerEmail;
use App\Models\Agent\AgentPayment_voucher;
use App\Models\Crm\AgentPaymentVoucher;
use App\Models\Hotel;
use App\Models\HotelAgentPrice;
use App\Models\HotelsRate;
use App\Models\TransportAgentPrice;
use App\Models\TransportRate;
use App\Models\Umrah\GroupDetail;
use App\Models\VisaRate;
use Illuminate\Http\Request;
use App\Models\Accounts\Agent;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use PDF;
use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\Accounts\Transaction;
use App\Models\Crm\AgentUmrah;
use App\Models\Crm\AgentUmrahTransportDetail;
use App\Models\Crm\AgentUmrahHotelDetail;
use App\Models\Crm\AgentUmrahPaxDetail;
use App\Models\VisaAgentPrice;
use App\Models\Crm\GroundHandleRate;
use App\Models\UmrahTransportCity;
use Storage;
class AgentUmrahController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:umrah_trip_view', ['only' => ['index']]);
        $this->middleware('permission:umrah_trip_create', ['only' => ['create']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.agent_booking.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session_start();
        unset($_SESSION['content_rec']);
        $conversion_rate=DB::table('currencies')->where('currency_symbol','SAR')->value('rate');
        return view('agents.agent_booking.create',compact('conversion_rate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->arg==1) {
            $rules = [
                'agentID'=>'required',
                'pnr' => 'required',
                'arr_flight' => 'required',
                'arr_dep_date' => 'required',
                'arr_date' => 'required',
                'dep_flight' => 'required',
            ];
            $message = [
                'agentID.required'=>'Agent Required',
                'pnr.required' => 'Pnr Required',
                'arr_flight.required' => 'Flight Required',
                'arr_dep_date.required' => 'Departure Date Required',
                'arr_date.required' => 'Arrival Date Required',
                'dep_flight.required' => 'Departure Flight Required',
            ];
        }else{
            $rules = [
                'agentID'=>'required',
                'pnr' => 'required',
                'arr_flight' => 'required',
                'arr_dep_date' => 'required',
                'arr_date' => 'required',
                'dep_flight' => 'required',
                'group_leader' => 'required',
            ];
            $message = [
                'agentID.required'=>'Agent Required',
                'pnr.required' => 'Pnr Required',
                'arr_flight.required' => 'Flight Required',
                'arr_dep_date.required' => 'Departure Date Required',
                'arr_date.required' => 'Arrival Date Required',
                'dep_flight.required' => 'Departure Flight Required',
                'group_leader.required' => 'Group Leader Required',
            ];
        }
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        try {
            //save umrah flight details
            $data['flight']=$request->flight;
            $data['pnr']=$request->pnr;
            $data['arr_flight']=$request->arr_flight;
            $data['arr_dep_date']=$request->arr_dep_date;
            $data['arr_dep_time']=$request->arr_dep_time;
            $data['arr_date']=$request->arr_date;
            $data['arr_time']=$request->arr_time;
            $data['arr_sector']=$request->arr_sector;
            $data['arr_terminal']=$request->arr_terminal;
            $data['dep_flight']=$request->dep_flight;
            $data['dep_date']=$request->dep_date;
            $data['dep_dime']=$request->dep_dime;
            $data['duration']=$request->duration;
            $data['dep_arr_date']=$request->dep_arr_date;
            $data['dep_arr_time']=$request->dep_arr_time;
            $data['dep_sector']=$request->dep_sector;
            $data['dep_terminal']=$request->dep_terminal;
            $data['ground_handle_product']=$request->ground_handle_product;
            $data['other_ground_information']=$request->other_ground_information;
            $data['ground_price']=$request->ground_price;
            $data['status']=false;
            $data['group_no']=$request->group_no;
            $data['group_name']=$request->group_name;
            $agentID=Agent::find($request->agentID)->UID;
            $data['created_by']=$agentID;
            $data['data_enter_by']=Auth::user()->id;
            $data['conversion_rate']=$request->conversion_rate;
            $data['currency']='SAR';
            $data['trip_includes']=implode(',',$request->trip_includes);
            if(isset($request->UID)){
                $id=$request->UID;
            }else{
                $id=0;
            }
            if($request->arg==1){
                $data['draft']=true;
            }else{
                $data['draft']=0;
            }
            if($id==0 || $id==''){
                $ret=AgentUmrah::create($data);
                $UID=$ret->id;
            }else{
                AgentUmrah::where('id',$id)->update($data);
                $UID=$id;
            }
            //transport details
            AgentUmrahTransportDetail::where('UID',$id)->delete();
            $count=count($request->transport_date);
            for ($i = 0; $i < $count; $i++) {
                if ($request['transport_type'][$i] == 7) {
                    $transport_cost = ($request['transport_cost'][$i]) * ($request['no_pax'][$i]);
                } else {
                    $transport_cost = ($request['transport_cost'][$i]) * ($request['vehicle'][$i]);
                }
                $transport[] = array('transport_date' => $request['transport_date'][$i],
                    'transport_time'=>$request['transport_time'][$i],
                    'from_city' => $request['from_city'][$i], 'to_city' => $request['to_city'][$i],
                    'transport_type' => $request['transport_type'][$i], 'no_pax' => $request['no_pax'][$i],
                    'vehicle' => $request['vehicle'][$i], 'rate' => $request['trans_rate'][$i],
                    'net_rate' => $request['net_rate'][$i],
                    'sar_amount' => $request['net_rate'][$i],
                    'TRID' => ((!empty($request['TRID'][$i])) ? $request['TRID'][0] : $request['TRID'][0]),
                    'transport_cost' => $transport_cost, 'UID' => $UID);
            }
            AgentUmrahTransportDetail::insert($transport);
            //hotel details
            $hcount=count($request->hotel_id);
            AgentUmrahHotelDetail::where('UID', $id)->delete();
            if($hcount>0) {
                for ($j = 0; $j < $hcount; $j++) {
                    $hotel_records[] = array(
                        'city' => $request['city'][$j],
                        'hotel_id' => $request['hotel_id'][$j],
                        'room_type' => $request['room_type'][$j],
                        'room' => $request['room'][$j], 'no_pax' => $request['no_pax'][$j],
                        'checkin' => $request['checkin'][$j], 'nights' => $request['nights'][$j],
                        'checkout' => $request['checkout'][$j], 'rate' => $request['hotel_rate'][$j],
                        'net_rate' => $request['hnet_rate'][$j],
                        'sar_amount' => $request['hnet_rate'][$j],
                        'HRID' => ((!empty($request['HRID'][$j])) ? $request['HRID'][0] : $request['HRID'][$j]),
                        'hotel_cost' => ($request['hotel_cost'][$j]) * ($request['room'][$j]) * ($request['nights'][$j]),
                        'UID' => $UID);
                }
                AgentUmrahHotelDetail::insert($hotel_records);
            }
            session_start();
            AgentUmrahPaxDetail::where('UID', $id)->delete();
            if(isset($_SESSION['content_rec'])) {
                foreach ($_SESSION['content_rec'] as $item) {
                    if($request->group_leader== $item['pax_name'])
                    {
                        $group_leader = 1;
                    } else {
                        $group_leader = 0;
                    }
                    $thisData[] = [
                        'title' => $item['title'],
                        'pax_name' => $item['pax_name'],
                        'father_name' => $item['father_name'],
                        'middle_name' => $item['middle_name'],
                        'last_name' => $item['last_name'],
                        'gender' => $item['gender'],
                        'dob' => $item['dob'],
                        'cnic' => $item['cnic'],
                        'nationality' => $item['nationality'],
                        'passport_type' => $item['passport_type'],
                        'passport' => $item['passport'],
                        'passport_country' => $item['passport_country'],
                        'passport_issue_date' => $item['issue_date'],
                        'passport_expire_date' => $item['expirty_date'],
                        'pax_type' => $item['pax_type'],
                        'visa_rate' => $item['vr'],
                        'sar_amount' => $item['vr'],
                        'cnic_photo' => $item['cnic_photos'],
                        'passport_photo' => $item['passport_photos'],
                        'vaccine_photo' => $item['vaccine_card_photo'],
                        'UID' => $UID,
                        'group_leader' => $group_leader,
                        'flight_price' => $item['flight_price'],
                        'VRID' => $item['VRID'],
                        'visa_cost' => $item['visa_cost'],
                        'age' => $item['age'],
                        'mehram' => $item['mehram']
                    ];
                }
                AgentUmrahPaxDetail::insert($thisData);
            }
            DB::commit();
            $id=$UID;
            return compact('id');
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //@dispay data in list
    public function get_data(Request $request){
        $res=DB::table('agent_umrahs AS a')
            ->select('a.*',DB::raw('(SELECT sum(tr.net_rate) 
            FROM agent_umrah_transport_details tr WHERE tr.UID=a.id) AS total_transport'),
                DB::raw('(SELECT sum(h.net_rate) 
            FROM agent_umrah_hotel_details h WHERE h.UID=a.id) AS total_hotel'),
                DB::raw('(SELECT count(p.id)
            FROM agent_umrah_pax_details p WHERE p.UID=a.id) AS totalPax'),
                DB::raw('(SELECT sum(v.visa_rate)
            FROM agent_umrah_pax_details v WHERE v.UID=a.id) AS total_visa'),
                DB::raw('(SELECT sum(v.flight_price)
            FROM agent_umrah_pax_details v WHERE v.UID=a.id) AS total_flight'),
                'users.name AS agentName',
                DB::raw('(select comp_name from ground_handle_rates where id=a.ground_handle_product) AS comp_name'))
            ->leftjoin('users', 'a.created_by','users.id')
            ->whereBetween(DB::raw('DATE(a.created_at)'), Account::financial_year())
            ->when($request->agentID, function($query)use($request){
                $agentID=Agent::where('id',$request->agentID)->value('UID');
                $query->where('created_by', $agentID);
        })->orderBy('a.id','DESC')->paginate(50);
        return $res;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flight=DB::table('agent_umrahs')
            ->join('cities', 'agent_umrahs.arr_terminal', 'cities.id')
            ->join('cities AS c', 'agent_umrahs.dep_terminal', 'c.id')
            ->select('agent_umrahs.*', 'cities.name AS city_name','c.name AS dep_ter')->where('agent_umrahs.id', $id)->first();
        $transport=DB::table('agent_umrah_transport_details')
            ->join('umrah_transport_cities', 'agent_umrah_transport_details.from_city', 'umrah_transport_cities.id')
            ->join('umrah_transport_cities As C', 'agent_umrah_transport_details.to_city', 'C.id')
            ->select('agent_umrah_transport_details.*', 'umrah_transport_cities.name as from_city', 'C.name AS to_city')
            ->where('agent_umrah_transport_details.UID', $id)->get();
        $hotels=DB::table('agent_umrah_hotel_details')
            ->join('cities', 'agent_umrah_hotel_details.city','cities.id')
            ->join('hotels', 'agent_umrah_hotel_details.hotel_id','hotels.id')
            ->select('agent_umrah_hotel_details.*', 'hotels.name AS hotel_name','cities.name AS city_name')->where('UID', $id)->get();
        $pax=DB::table('agent_umrah_pax_details')
            ->join('countries','agent_umrah_pax_details.nationality', 'countries.id')
            ->select('agent_umrah_pax_details.*','countries.name')->where('UID', $id)
            ->orderBy('group_leader','DESC')->get();
        $agent=Agent::where('UID',$flight->created_by)->first();
        $ground_hand_comp=GroundHandleRate::where('id',$flight->ground_handle_product)->value('comp_name');
        $family_head=AgentUmrahPaxDetail::where(['UID'=>$id, 'group_leader'=>1])->value('pax_name');
        $group_details=DB::table('group_details')->where('id',$flight->group_no)->first();
        $data=compact('flight','agent', 'transport','hotels','pax',
            'ground_hand_comp','family_head','group_details');
        view()->share('data', $data);
        $pdf= PDF::loadView('agents.agent_booking.umrah_voucher', $data);
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
        $result=AgentUmrah::find($id);
        $hotels=AgentUmrahHotelDetail::where('UID', $id)->get();
        $transports=AgentUmrahTransportDetail::where('UID', $id)->get();
        $paxes=AgentUmrahPaxDetail::with('country')->where('UID', $id)->get();
        session_start();
        foreach ($paxes as $pax){
            $thisData[] = ['title' => $pax->title, 'pax_name' => $pax->pax_name,
                'father_name' => $pax->father_name, 'middle_name' => $pax->middle_name,
                'last_name' => $pax->last_name, 'gender' => $pax->gender, 'dob' => $pax->dob,
                'cnic' => $pax->cnic, 'nationality' => $pax->nationality,
                'passport_type' => $pax->passport_type, 'passport' => $pax->passport,
                'passport_country' => $pax->passport_country, 'issue_date' => $pax->issue_date,
                'expirty_date' => $pax->expirty_date,
                'pax_type'=>$pax->pax_type, 'vr'=>$pax->visa_rate,
                'cnic_photos'=>'', 'passport_photos'=>'',
                'vaccine_card_photo'=>'',
                'flight_price'=>$pax->flight_price, 'visa_cost'=>$pax->visa_cost,
                'age'=>$pax->age,
                'mehram'=>$pax->mehram,
                'VRID'=>$pax->VRID];
        }
        if(isset($thisData)){
            $_SESSION["content_rec"] =$thisData;
        }
        $conversion_rate=DB::table('currencies')->where('currency_symbol','SAR')->value('rate');
        return view('agents.agent_booking.edit',
            compact('result','hotels','transports', 'paxes','conversion_rate'));
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
            $rules = [
                'pnr' => 'required',
                'arr_flight' => 'required',
                'arr_dep_date' => 'required',
                'arr_date' => 'required',
                'dep_flight' => 'required',
                'group_leader' => 'required',
            ];
            $message = [
                'pnr.required' => 'Pnr Required',
                'arr_flight.required' => 'Flight Required',
                'arr_dep_date.required' => 'Departure Date Required',
                'arr_date.required' => 'Arrival Date Required',
                'dep_flight.required' => 'Departure Flight Required',
                'group_leader.required' => 'Group Leader Required',
            ];
        $this->validate($request, $rules, $message);
//        $data=$request->except(['_token', 'password', 'roles']);
        DB::beginTransaction();
        try {
            //save umrah flight details
            $data['flight']=$request->flight;
            $data['pnr']=$request->pnr;
            $data['arr_flight']=$request->arr_flight;
            $data['arr_dep_date']=$request->arr_dep_date;
            $data['arr_dep_time']=$request->arr_dep_time;
            $data['arr_date']=$request->arr_date;
            $data['arr_time']=$request->arr_time;
            $data['arr_sector']=$request->arr_sector;
            $data['arr_terminal']=$request->arr_terminal;
            $data['dep_flight']=$request->dep_flight;
            $data['dep_date']=$request->dep_date;
            $data['dep_dime']=$request->dep_dime;
            $data['duration']=$request->duration;
            $data['dep_arr_date']=$request->dep_arr_date;
            $data['dep_arr_time']=$request->dep_arr_time;
            $data['dep_sector']=$request->dep_sector;
            $data['dep_terminal']=$request->dep_terminal;
            $data['ground_handle_product']=$request->ground_handle_product;
            $data['other_ground_information']=$request->other_ground_information;
            $data['ground_price']=$request->ground_price;
            $data['status']=false;
            $data['group_no']=$request->group_no;
            $data['group_name']=$request->group_name;
            $data['updated_by']=Auth::user()->id;
            $agentID=Agent::find($request->agentID)->UID;
            $data['created_by']=$agentID;
            $data['conversion_rate']=$request->conversion_rate;
            $data['currency']='SAR';
            $data['trip_includes']=implode(',',$request->trip_includes);
            $id=$request->UID;
            AgentUmrah::where('id',$id)->update($data);
            $UID=$id;
            //transport details
            AgentUmrahTransportDetail::where('UID',$id)->delete();
            $count=count($request->transport_date);
            for ($i = 0; $i < $count; $i++) {
                if ($request['transport_type'][$i] == 7) {
                    $transport_cost = ($request['transport_cost'][$i]) * ($request['no_pax'][$i]);
                } else {
                    $transport_cost = ($request['transport_cost'][$i]) * ($request['vehicle'][$i]);
                }
                $transport[] = array(
                    'transport_date' => $request['transport_date'][$i],
                    'transport_time'=>$request['transport_time'][$i],
                    'from_city' => $request['from_city'][$i],
                    'to_city' => $request['to_city'][$i],
                    'transport_type' => $request['transport_type'][$i],
                    'no_pax' => $request['no_pax'][$i],
                    'vehicle' => $request['vehicle'][$i],
                    'rate' => $request['trans_rate'][$i],
                    'net_rate' => $request['net_rate'][$i],
                    'TRID' => ((!empty($request['TRID'][$i])) ? $request['TRID'][0] : $request['TRID'][0]),
                    'transport_cost' => $transport_cost,
                    'UID' => $UID
                );
            }
            AgentUmrahTransportDetail::insert($transport);
            //hotel details
            $hcount=count($request->hotel_id);
            AgentUmrahHotelDetail::where('UID', $id)->delete();
            if($hcount>0) {
                for ($j = 0; $j < $hcount; $j++) {
                    $hotel_records[] = array(
                        'city' => $request['city'][$j],
                        'hotel_id' => $request['hotel_id'][$j],
                        'room_type' => $request['room_type'][$j],
                        'room' => $request['room'][$j],
                        'no_pax' => $request['no_pax'][$j],
                        'checkin' => $request['checkin'][$j],
                        'nights' => $request['nights'][$j],
                        'checkout' => $request['checkout'][$j],
                        'rate' => $request['hotel_rate'][$j],
                        'net_rate' => $request['hnet_rate'][$j],
                        'HRID' => ((!empty($request['HRID'][$j])) ? $request['HRID'][0] : $request['HRID'][$j]),
                        'hotel_cost' => ($request['hotel_cost'][$j]) * ($request['room'][$j]) * ($request['nights'][$j]),
                        'UID' => $UID);
                }
                AgentUmrahHotelDetail::insert($hotel_records);
            }
            session_start();
            AgentUmrahPaxDetail::where('UID', $id)->delete();
            if(isset($_SESSION['content_rec'])) {
                foreach ($_SESSION['content_rec'] as $item) {
                    if ($request->group_leader==$item['pax_name']) {
                        $group_leader = 1;
                    } else {
                        $group_leader = 0;
                    }
                    $thisData[] = [
                        'title' => $item['title'],
                        'pax_name' => $item['pax_name'],
                        'father_name' => $item['father_name'],
                        'middle_name' => $item['middle_name'],
                        'last_name' => $item['last_name'],
                        'gender' => $item['gender'],
                        'dob' => $item['dob'],
                        'cnic' => $item['cnic'],
                        'nationality' => $item['nationality'],
                        'passport_type' => $item['passport_type'],
                        'passport' => $item['passport'],
                        'passport_country' => $item['passport_country'],
                        'passport_issue_date' => $item['issue_date'],
                        'passport_expire_date' => $item['expirty_date'],
                        'pax_type' => $item['pax_type'],
                        'visa_rate' => $item['vr'],
                        'cnic_photo' => $item['cnic_photos'],
                        'passport_photo' => $item['passport_photos'],
                        'vaccine_photo' => $item['vaccine_card_photo'],
                        'UID' => $UID,
                        'group_leader' => $group_leader,
                        'flight_price' => $item['flight_price'],
                        'VRID' => $item['VRID'],
                        'visa_cost' => $item['visa_cost'],
                        'age' => $item['age'],
                        'mehram' => $item['mehram']
                    ];
                }
                AgentUmrahPaxDetail::insert($thisData);
            }
            DB::commit();
            $id=$UID;
            return compact('id');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //approve uv
    public function approve_uv(Request $request){
        $id=$request->id;
        DB::BeginTransaction();
        try{
            //umrah voucher udpate
            $app['status']=true;
            $app['hotel_brn_price']=$request->hotel_brn_price;
            $app['transport_brn_price']=$request->transport_brn_price;
            $app['approved_time']=date('Y-m-y h:i:s');
            $app['approved_by']=Auth::user()->id;
            DB::table('agent_umrahs')->where('id', $id)->update($app);
            $UID=DB::table('agent_umrahs AS a')->select('a.*')
                ->where('a.id',$id)->first();
            $agentID=Agent::where('UID', $UID->created_by)->value('id');
            $transport=DB::table('agent_umrah_transport_details AS tr')
                ->select(DB::raw('sum(tr.net_rate) AS total_transport'))
                ->where('UID', $id)->first();
            $hotel=DB::table('agent_umrah_hotel_details AS h')
                ->select(DB::raw('sum(h.net_rate) AS total_hotel'))->where('UID', $id)->first();
            $payment_to=TransactionAccount::where('PID',21)
                ->where('Parent_Type',$agentID)->first();
            $visa=DB::table('agent_umrah_pax_details AS p')
                ->select(DB::raw('sum(p.visa_rate) AS total_visa'),
                    DB::raw('sum(p.flight_price) AS total_flight'))->where('UID', $id)->first();
            $total=($transport->total_transport)+($hotel->total_hotel)+($visa->total_visa)+($UID->hotel_brn_price)+($UID->transport_brn_price);
            $ex_voucher=AgentPaymentVoucher::where('invID', $id)->first();
            if($ex_voucher) {
                Transaction::where('trans_code', $ex_voucher->trans_code)->delete();
            }
            $data['transaction_date']=date('Y-m-d');
            $data['agentID']=$agentID;
            if($UID->conversion_rate>0) {
                $data['amount'] = $total * $UID->conversion_rate;
            }else{
                $data['amount'] = $total;
            }
            $data['invID']=$id;
            $data['narration']='Umrah Booking against reference number ('.$id.')';
            if($ex_voucher==null) {
                $data['trans_code']=Account::trans_code();
                $data['created_at']=date('Y-m-d h:i:s');
                AgentPayment_voucher::insert($data);
            }else{
                $data['updated_at']=date('Y-m-d h:i:s');
                AgentPayment_voucher::where('invID', $ex_voucher->invID)->update($data);
            }
            //transaction entry
            $tData['trans_date']=date('Y-m-d');
            $tData['posting_date']=date('Y-m-d');
            $tData['narration']='Umrah Booking against reference number ('.$id.')';
            if($UID->conversion_rate>0) {
                $tData['amount']=($total*$UID->conversion_rate)-$visa->total_flight;
            }else{
                $tData['amount']=$total-$visa->total_flight;
            }
            $tData['status']=1;
            $tData['vt']=2;
            $tData['dr_cr']=1;
            $tData['trans_code']=Account::trans_code();
            $tData['trans_acc_id']=$payment_to->id;
            Transaction::create($tData);
            //transport cost
            $tData['dr_cr']=2;
            $tData['vt']=12;
            $trans_transports=DB::table('agent_umrah_transport_details')
                ->select('agent_umrah_transport_details.*')
                ->where('UID', $id)->where('TRID', '!=', 0)->get();
            foreach ($trans_transports as $trans_transport){
                if($trans_transport->arrangement==0) {
                    $tr_source = TransportRate::where('id', $trans_transport->TRID)->first();
                    $tData['trans_acc_id'] = $tr_source->source;
                    $tData['amount'] = ($trans_transport->transport_cost)*($UID->conversion_rate);
                    Transaction::create($tData);
                }
            }
            //hotel cost
            $trans_hotels=DB::table('agent_umrah_hotel_details')
                ->select('agent_umrah_hotel_details.*')->where('UID', $id)->get();
            foreach ($trans_hotels as $trans_hotel){
                if($trans_hotel->arrangement==0) {
                    $h_source = HotelsRate::where('id', $trans_hotel->HRID)->first();
                    if($h_source) {
                        $tData['trans_acc_id'] = $h_source->source;
                        $tData['amount'] = ($trans_hotel->hotel_cost)*($UID->conversion_rate);
                        Transaction::create($tData);
                    }
                }
            }
            //visa cost
            $trans_visas=DB::table('agent_umrah_pax_details')
                ->select('agent_umrah_pax_details.*')->where('UID', $id)->get();
            foreach ($trans_visas as $trans_visa){
                $v_source=VisaRate::where('id', $trans_visa->VRID)->first();
                if($v_source) {
                    $tData['trans_acc_id'] = $v_source->source;
                    $tData['amount'] = ($trans_visa->visa_cost)*($UID->conversion_rate);
                    Transaction::create($tData);
                }
            }
//            UmrahVouhcerEmail::dispatch()->delay(now()->addSeconds(30));
//            self::email_voucher($id);
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
        return response()->json(['success' => 'Approved Successfully']);

    }
    //save pdf file while approving umrah vouhcer
    //uv details
    public function umrah_details($id){
        $flight=DB::table('agent_umrahs')
            ->leftjoin('cities', 'agent_umrahs.arr_terminal', 'cities.id')
            ->leftjoin('cities AS c', 'agent_umrahs.dep_terminal', 'c.id')
            ->select('agent_umrahs.*', 'cities.name AS city_name','c.name AS dep_ter')->where('agent_umrahs.id', $id)->first();
        $transport=DB::table('agent_umrah_transport_details')
            ->join('umrah_transport_cities', 'agent_umrah_transport_details.from_city', 'umrah_transport_cities.id')
            ->join('umrah_transport_cities As C', 'agent_umrah_transport_details.to_city', 'C.id')
            ->select('agent_umrah_transport_details.*', 'umrah_transport_cities.name as from_city', 'C.name AS to_city')
            ->where('agent_umrah_transport_details.UID', $id)->get();
        $hotels=DB::table('agent_umrah_hotel_details')
            ->join('cities', 'agent_umrah_hotel_details.city','cities.id')
            ->join('hotels', 'agent_umrah_hotel_details.hotel_id','hotels.id')
            ->select('agent_umrah_hotel_details.*', 'hotels.name AS hotel_name','cities.name AS city_name')->where('UID', $id)->get();
        $pax=DB::table('agent_umrah_pax_details')
            ->leftjoin('countries','agent_umrah_pax_details.nationality', 'countries.id')
            ->select('agent_umrah_pax_details.*','countries.name')->where('UID', $id)->get();
        return view('agents.agent_booking.umrah_details', compact('flight',
            'transport','hotels','pax'));
    }
    //pax details
    public function pax_save(Request $request){
        $rules=[
            'pax_name'=>'required',
            'gender'=>'required',
            'passport'=>'required',
            'nationality'=>'required',
            'dob'=>'required',
            'age'=>'required',
        ];
        $message=[
            'pax_name.required'=>'Pax Name Required',
            'gender.required'=>'Gender Required',
            'passport.required'=>'Passport Required',
            'nationality.required'=>'Please Select Nationality',
            'dob.required'=>'Date of Birth Required',
            'age.required'=>'Age Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except('token');
        session_start();
        $cnic_photo='';
        if(isset($request->cnic_photos)) {
            foreach ($request->cnic_photos as $photo) {
                $cnic_photo.=url('/storage/app/'.$photo->store('public/umrah/cnic')).',';
            }
            $cnic_photo=rtrim($cnic_photo,',');
        }
        $passport_photos='';
        if(isset($request->cnic_photos)) {
            foreach ($request->passport_photos as $passport_photo) {
                $passport_photos.=url('/storage/app/'.$passport_photo->store('public/umrah/passport')).',';
            }
            $passport_photos=rtrim($cnic_photo,',');
        }
        $vaccine_card_photo='';
        if(isset($request->vaccine_card_photo)) {
            $vaccine_card_photo=url('/storage/app/'.$request->vaccine_card_photo->store('public/umrah/vaccine'));
        }
        $newData=array([
            'title'=>$request->title,
            'pax_name'=>$request->pax_name,
            'father_name'=>$request->father_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'cnic'=>$request->cnic,
            'nationality'=>$request->nationality,
            'passport_type'=>$request->passport_type,
            'passport'=>$request->passport,
            'passport_country'=>$request->passport_country,
            'issue_date'=>$request->issue_date,
            'expirty_date'=>$request->expirty_date,
            'pax_type'=>$request->pax_type,
            'vr'=>$request->vr,
            'cnic_photos'=>$cnic_photo,
            'passport_photos'=>$passport_photos,
            'vaccine_card_photo'=>$vaccine_card_photo,
            'flight_price'=>$request->flight_price,
            'visa_cost'=>$request->visa_cost,
            'age'=>$request->age,
            'mehram'=>$request->mehram,
            'VRID'=>$request->VRID
        ]
        );
        if(isset($_SESSION['content_rec'])) {
            $found = false;
            foreach ($_SESSION['content_rec'] as $item) {
                if (!empty($item) && $item['passport']==$request->passport) {
                    $thisData[] = ['title' => $request->title, 'pax_name' => $request->pax_name,
                        'father_name' => $request->father_name, 'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name, 'gender' => $request->gender, 'dob' => $request->dob,
                        'cnic' => $request->cnic, 'nationality' => $request->nationality,
                        'passport_type' => $request->passport_type, 'passport' => $request->passport,
                        'passport_country' => $request->passport_country, 'issue_date' => $request->issue_date,
                        'expirty_date' => $request->expirty_date,
                        'pax_type'=>$request->pax_type, 'vr'=>$request->vr,
                        'cnic_photos'=>$cnic_photo, 'passport_photos'=>$passport_photos,
                        'vaccine_card_photo'=>$vaccine_card_photo,
                        'flight_price'=>$request->flight_price, 'visa_cost'=>$request->visa_cost,
                        'age'=>$request->age,
                        'mehram'=>$request->mehram,
                        'VRID'=>$request->VRID];
                    $found = true;
                } else {
                    $thisData[] = ['title' => $item['title'], 'pax_name' => $item['pax_name'], 'father_name' => $item['father_name'],
                        'middle_name' => $item['middle_name'], 'last_name' => $item['last_name'], 'gender' => $item['gender'],
                        'dob' => $item['dob'], 'cnic' => $item['cnic'], 'nationality' => $item['nationality'],
                        'passport_type' => $item['passport_type'], 'passport' => $item['passport'],
                        'passport_country' => $item['passport_country'], 'issue_date' => $item['issue_date'],
                        'expirty_date' => $item['expirty_date'], 'pax_type'=>$item['pax_type'],
                        'vr'=>$item['vr'],'cnic_photos'=>$item['cnic_photos'], 'passport_photos'=>$item['passport_photos'],
                        'vaccine_card_photo'=>$item['vaccine_card_photo'],
                        'flight_price'=>$item['flight_price'], 'visa_cost'=>$item['visa_cost'],
                        'age'=>$item['age'], 'mehram'=>$item['mehram'],
                        'VRID'=>$item['VRID']];
                }
            }
            if ($found == false){
                $_SESSION["content_rec"] = array_merge($thisData, $newData);
            }else {
                $_SESSION["content_rec"] =$thisData;
            }
        }else{
            $_SESSION['content_rec']=$newData;
        }
        return ($_SESSION['content_rec']);
    }
    //@edit umrah pax
    public function edit_upax($id){
        session_start();
        if(isset($_SESSION['content_rec'])){
            foreach ($_SESSION['content_rec'] as $item){
                if($item['passport']==$id) {
                    $thisData = ['title' => $item['title'], 'pax_name' => $item['pax_name'], 'father_name' => $item['father_name'],
                        'middle_name' => $item['middle_name'], 'last_name' => $item['last_name'], 'gender' => $item['gender'],
                        'dob' => $item['dob'], 'cnic' => $item['cnic'], 'nationality' => $item['nationality'],
                        'passport_type' => $item['passport_type'], 'passport' => $item['passport'],
                        'passport_country' => $item['passport_country'], 'issue_date' => $item['issue_date'],
                        'expirty_date' => $item['expirty_date'], 'pax_type'=>$item['pax_type'],
                        'vr'=>$item['vr'],'cnic_photos'=>$item['cnic_photos'], 'passport_photos'=>$item['passport_photos'],
                        'vaccine_card_photo'=>$item['vaccine_card_photo'],
                        'flight_price'=>$item['flight_price'],'visa_cost'=>$item['visa_cost'],
                        'age'=>$item['age'], 'mehram'=>$item['mehram'],
                        'VRID'=>$item['VRID']];
                    return response()->json($thisData);
                }
            }

        }
    }
    //remove umrah pax
    public function remove_upax($id){
        session_start();
        $thisData[]=array();
        if(isset($_SESSION['content_rec'])){
            foreach ($_SESSION['content_rec'] as $item){
                if($item['passport']!=$id) {
                    $thisData[] = ['title' => $item['title'], 'pax_name' => $item['pax_name'], 'father_name' => $item['father_name'],
                        'middle_name' => $item['middle_name'], 'last_name' => $item['last_name'], 'gender' => $item['gender'],
                        'dob' => $item['dob'], 'cnic' => $item['cnic'], 'nationality' => $item['nationality'],
                        'passport_type' => $item['passport_type'], 'passport' => $item['passport'],
                        'passport_country' => $item['passport_country'], 'issue_date' => $item['issue_date'],
                        'expirty_date' => $item['expirty_date'], 'pax_type'=>$item['pax_type'],
                        'vr'=>$item['vr'], 'cnic_photos'=>$item['cnic_photos'], 'passport_photos'=>$item['passport_photos'],
                        'vaccine_card_photo'=>$item['vaccine_card_photo'], 'flight_price'=>$item['flight_price'],
                        'visa_cost'=>$item['visa_cost'],
                        'age'=>$item['age'], 'mehram'=>$item['mehram'],
                        'VRID'=>$item['VRID']];
                }
            }
            return $_SESSION["content_rec"] = $thisData;
        }
    }
    //==============================Fetch Rates
    //fetch hotel rate against hotel id and room type
    public function fetch_hotel_rate(Request $request){
        $hID=$request->hID;
        $checkin=$request->checkin;
        $checkin= date('Y-m-d', strtotime($checkin.' + 1day'));
        $checkout=$request->checkout;
        $chekinMonth=date('m',strtotime($checkin));
        $chekoutMonth=date('m',strtotime($checkout));
        $agentID=$request->agentID;
        //$agentID=Agent::where('UID', $agentID)->value('id');
        $res_agent=HotelAgentPrice::where('agent', $agentID)->where('hotel_id', $hID)
            ->where('room_type', $request->type)->whereIn('month',[$chekinMonth,$chekoutMonth])
            ->orderBy('id', 'DESC')->pluck('HRID');
        $agent_price=HotelAgentPrice::where('agent', $agentID)->where('hotel_id', $hID)
            ->where('room_type', $request->type)->whereIn('month',[$chekinMonth,$chekoutMonth])
            ->orderBy('id', 'DESC')->first();
//        $currency_rate=DB::table('hotels_rates')->where('id', $agent_price->HRID)->value('currency_rate');
        $currency_rate=DB::table('currencies')->where('currency_symbol','SAR')->value('rate');
        //get rate checkin and checkout
        if($res_agent) {
            $res_rate = DB::table('hotel_vailidties')
                ->whereBetween('validity_date', [$checkin, $checkout])
                ->whereIn('hotel_vailidties.HRID', $res_agent)->sum('rate');
//            dd($res_rate);
            return compact( 'res_rate', 'currency_rate','agent_price');
        }
    }
    //fetch transport rate
    public function fetch_transport_rate(Request $request){
        $date=date('Y-m-d');
        $chekinMonth=date('m',strtotime($request->transport_date));
        $td=date('Y-m-d',strtotime($request->transport_date));
        $agentID=$request->agentID;
        //$agentID=Agent::where('UID', $agentID)->value('id');
        $res_agent=TransportAgentPrice::where('agent',$agentID)->where('from_city', $request->from_city)
            ->where('to_city',$request->to_city)->where('transport_type', $request->trans_type)->where('month',$chekinMonth)
            ->orderBy('id', 'DESC')->first();
        if($res_agent) {
            $res = TransportRate::where('id', $res_agent->TRID)->first();
            $currency_rate=DB::table('currencies')->where('currency_symbol','SAR')->value('rate');
            $res_rate = DB::table('transport_validities')->whereDate('validity_date', $td)
                ->where('TRID', $res_agent->TRID)->sum('rate');
            $agent_price = [$res_agent->markup_type, $res_agent->markup_value];
            return compact('res', 'agent_price', 'res_rate','currency_rate');
        }
    }

    //fetch visa rate
    public function fetch_visa_rate($type, $agentID){
        $date=date('Y-m-d');
        $res_rate=VisaAgentPrice::where('agents', $agentID)->orderBy('id', 'DESC')->first();
        $res=VisaRate::where('visa_type', 3)
            ->whereDate('validity_from','<=' ,$date)
            ->whereDate('validity_to', '>=', $date)
            ->where('id',$res_rate->VRID)
            ->first();
        //$agentArray=explode(',',$res_rate->agents);
        //if(in_array($agentID, $agentArray)){
        $agent_price=[$res_rate->markup_type, $res_rate->markup_value];
        $currency_rate=DB::table('currencies')->where('currency_symbol','SAR')->value('rate');
        //}
        return compact('res', 'agent_price','currency_rate');
    }
    public function get_visa_rate($type, $agentID){
        $ret=self::fetch_visa_rate($type, $agentID);
        if($type==1) {
            $net_sale = json_decode($ret['res']->adult_det, true)["'net_sale'"];
        }
        if($ret['agent_price'][0]==2){
            $net_sale=($net_sale)+($ret['agent_price'][1]);
            $visa_cost=$net_sale;
        }else{
            $net_sale=0;
            $visa_cost=0;
        }
        $net_sale=$net_sale;
        $visa_cost=$visa_cost;
        return compact('net_sale','visa_cost');
    }
    //fetch all umrag agent bookings
    public function bookings(){
        return view('crm.bookings.agent_umrah_booking.index');
    }
    public function get_bookings(Request $request){
        $res=DB::table('agent_umrahs AS a')
            ->select('a.*',DB::raw('(SELECT sum(tr.net_rate) 
            FROM agent_umrah_transport_details tr WHERE tr.UID=a.id) AS total_transport'),
                DB::raw('(SELECT sum(h.net_rate) 
            FROM agent_umrah_hotel_details h WHERE h.UID=a.id) AS total_hotel'),
                DB::raw('(SELECT count(p.id)
            FROM agent_umrah_pax_details p WHERE p.UID=a.id) AS totalPax'),
                DB::raw('(SELECT sum(v.visa_rate)
            FROM agent_umrah_pax_details v WHERE v.UID=a.id) AS total_visa'),
                DB::raw('(SELECT sum(v.flight_price)
            FROM agent_umrah_pax_details v WHERE v.UID=a.id) AS total_flight'))
            ->where('a.created_by', Auth::user()->id)->where('draft',0)->groupBy('pnr')
            ->paginate(50);
        return $res;
    }
    //get ground service details
    public function get_ground_handleservices($id){
        return GroundHandleRate::find($id);
    }
    //@get agent visitors linked with group id
    public function fetch_agent_visitors($id){
        //$result=AgentUmrahVisitor::with(['country'])->where('group_id', $id)->get();
        $result=DB::table('agent_umrah_visitors')
            ->leftJoin('countries','agent_umrah_visitors.nationality','countries.id')
            ->select('agent_umrah_visitors.*','countries.name AS country_name')
            ->where('group_id',$id)->where('agent_umrah_visitors.linked',0)->get();
        return response()->json($result);
    }
    //assignd visitors
    public function assigned_visitors(Request $request){
        $result=DB::table('agent_umrah_visitors')
            ->leftJoin('countries','agent_umrah_visitors.nationality','countries.id')
            ->select('agent_umrah_visitors.*','countries.name AS country_name')
            ->whereIn('agent_umrah_visitors.id',$request->paxes)->get();
        session_start();
        $oldData=[];
        foreach ($result as $pax){
            if($request->visa_price==1) {
                $vr=self::get_visa_rate($pax->pax_type, $request->agentID);
            }else{
                $vr=['net_sale'=>0,'visa_cost'=>0,'VRID'=>0];
            }
            $thisData[] = [
                'title' => $pax->title,
                'pax_name' => $pax->pax_name,
                'father_name' => $pax->father_name,
                'middle_name' => $pax->middle_name,
                'last_name' => $pax->last_name,
                'gender' => $pax->gender,
                'dob' => $pax->dob,
                'cnic' => $pax->cnic,
                'nationality' => $pax->nationality,
                'passport_type' => $pax->passport_type,
                'passport' => $pax->passport,
                'passport_country' => $pax->passport_country,
                'issue_date' => $pax->passport_issue_date,
                'expirty_date' => $pax->passport_expire_date,
                'pax_type'=>$pax->pax_type,
                'vr'=>$vr['net_sale'],
                'cnic_photos'=>'',
                'passport_photos'=>'',
                'vaccine_card_photo'=>'',
                'flight_price'=>0,
                'visa_cost'=>$vr['visa_cost'],
                'age'=>$pax->age,
                'mehram'=>$pax->mehram,
                'VRID'=>0
            ];
        }
        if(isset($_SESSION['content_rec'])){
            foreach ($_SESSION['content_rec'] as $item) {
                $oldData[] = [
                    'title' => $item['title'],
                    'pax_name' => $item['pax_name'],
                    'father_name' => $item['father_name'],
                    'middle_name' => $item['middle_name'],
                    'last_name' => $item['last_name'],
                    'gender' => $item['gender'],
                    'dob' => $item['dob'],
                    'cnic' => $item['cnic'],
                    'nationality' => $item['nationality'],
                    'passport_type' => $item['passport_type'],
                    'passport' => $item['passport'],
                    'passport_country' => $item['passport_country'],
                    'issue_date' => $item['issue_date'],
                    'expirty_date' => $item['expirty_date'],
                    'pax_type'=>$item['pax_type'],
                    'vr'=>$item['vr'],
                    'cnic_photos'=>$item['cnic_photos'],
                    'passport_photos'=>$item['passport_photos'],
                    'vaccine_card_photo'=>$item['vaccine_card_photo'],
                    'flight_price'=>$item['flight_price'],
                    'visa_cost'=>$item['visa_cost'],
                    'age'=>$item['age'],
                    'mehram'=>$item['mehram'],
                    'VRID'=>$item['VRID']
                ];
            }
        }
        if(isset($thisData)){
            $_SESSION["content_rec"] = array_merge($thisData, $oldData);
        }
        return ($_SESSION['content_rec']);
    }
    //seach transport availability
    public function search_transport_availability(Request $request){
        $result=DB::table('transport_reservation_brns')
            ->join('transport_brn_sectors','transport_reservation_brns.id','transport_brn_sectors.TRBID')
            ->where(['transport_brn_sectors.from_city'=>$request->form_city,'transport_brn_sectors.to_city'=>$request->to_city])->get();
        $htmlData='';
        foreach ($result as $item){
            $htmlData.='<div class="row" id="sector-'.$item->id.'">
                        <input type="hidden" name="" value="'.$item->id.'">
                        <input type="hidden" class="TRID" readonly="" name="TRID[]">
                        <input type="hidden" class="form-control form-control-sm transport_cost" readonly="" name="transport_cost[]">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden;">Select</label>
                                <input type="checkbox" class="form-control form-control-sm select-checkbox">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sector From</label>
                                <select readonly class="form-control form-control-sm select2 from_city">
                                    '.UmrahTransportCity::dropdown($item->from_city).'
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sector To</label>
                                <select readonly class="form-control form-control-sm select2 to_city">
                                    '.UmrahTransportCity::dropdown($item->to_city).'
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Date</label>
                            <input readonly type="text" name="" class="form-control form-control-sm sector_date" value="'.$item->sector_date.'">
                        </div>
                        <div class="col-md-1">
                            <label>Time</label>
                            <input readonly type="text" name="" class="form-control form-control-sm sector_time" value="'.$item->sector_time.'">
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Available</label>
                                <input readonly onclick="open_transport_seat(this, \''.$item->id.'\')" type="text" name="" value="'.$this->available_capacity($item->brn, $request->form_city, $request->to_city).'" class="form-control form-control-sm" placeholder="4">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Avail</label>
                                <input readonly type="text" name="" class="form-control form-control-sm selected_pax" placeholder="00">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Rate</label>
                                <input readonly type="text" name="" class="form-control form-control-sm selected_pax_rate" placeholder="00">
                            </div>
                        </div>
                    </div>
                    <!--row-->';
        }
        return compact('htmlData');
    }
    //available capacity
    public function available_capacity($brn='', $fc='', $tc=''){
        $total=DB::table('transport_reservation_brns')
            ->leftJoin('transport_brn_sectors','transport_reservation_brns.id','transport_brn_sectors.TRBID')
            ->where('brn', ''.$brn.'')->where(['from_city'=>$fc, 'to_city'=>$tc])->first();
        $visa_used=DB::table('transport_brns')->where('TRBRN', $total->TRBID)->sum('no_pax');
        $available=$total->total_capacity-$visa_used;
        return $available;
    }
    //hoel availability
    public function search_hotel_availability(Request $request){
        $result=DB::table('hotel_reservation_brns AS h')->join('hotels','h.hotel_id','hotels.id')
            ->select('*','h.city_id AS city')
            ->when($request->city_id, function ($query) use ($request){
                $query->where('h.city_id',$request->city_id);
            })
            ->when($request->room_type, function ($query) use ($request){
                $query->where('h.room_type',$request->room_type);
            }) ->when($request->checkin, function ($query) use ($request){
                $query->where('h.checkin',$request->checkin);
            })->get();
        $htmlData='';
        $i=0;
        foreach ($result as $item){
            $htmlData.=' <div  class="row" id="room-'.$item->id.'">
                        <input type="hidden" class="city_id" value="'.$item->city.'">
                        <input type="hidden" class="HRID" name="HRID[]">
                        <input type="hidden" class="hotel_cost" name="hotel_cost[]">
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label style="visibility: hidden;">Select</label>':'').'
                                <input type="checkbox" class="form-control form-control-sm select-checkbox">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                '.($i==0?'<label>Hotel</label>':'').'
                                <select class="form-control form-control-sm select2 hotel_id">
                                    '.Hotel::hotelList($item->hotel_id).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                '.($i==0?'<label>Room Type</label>':'').'
                                <select class="form-control form-control-sm select2 room_type">
                                    '.helper::room_type($item->room_type).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>#Room</label>':'').'
                                <input onclick="open_hotel_room(this, '.$item->id.')" type="text" readonly class="form-control form-control-sm no_rooms" value="'.$item->no_room.'">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>#Bed</label>':'').'
                                <input type="text" disabled class="form-control form-control-sm no_beds" value="'.$this->available_hotel_capacity($item->brn).'">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>Checkin</label>':'').'
                                <input style="font-size:12px;padding:5px" type="text" disabled class="form-control form-control-sm checkin" value="'.$item->checkin.'">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>#Nights</label>':'').'
                                <input type="text" disabled class="form-control form-control-sm nights" value="'.$item->nights.'">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>Checkout</label>':'').'
                                <input style="font-size:12px; padding:5px;" type="text" disabled class="form-control form-control-sm checkout" value="'.$item->checkout.'">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>#Avail Rm</label>':'').'
                                <input type="text" class="form-control form-control-sm selected_room">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>#Avail Pax</label>':'').'
                                <input type="text" class="form-control form-control-sm selected_pax">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                '.($i==0?'<label>Rate</label>':'').'
                                <input type="text" readonly class="form-control form-control-sm hotel_rate">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->';
            $i++;
        }
        return compact('htmlData');
    }
    //available hotel capacity
    public function available_hotel_capacity($brn=''){
        $total=DB::table('hotel_reservation_brns')->where('brn', ''.$brn.'')->first();
        $available=0;
        $available=$total->total_capacity;
        return $available;
    }
    //email vuohcer to all related
    function email_voucher($id){
        $flight=DB::table('agent_umrahs')
            ->join('cities', 'agent_umrahs.arr_terminal', 'cities.id')
            ->join('cities AS c', 'agent_umrahs.dep_terminal', 'c.id')
            ->select('agent_umrahs.*', 'cities.name AS city_name','c.name AS dep_ter')->where('agent_umrahs.id', $id)->first();
        $transport=DB::table('agent_umrah_transport_details')
            ->join('umrah_transport_cities', 'agent_umrah_transport_details.from_city', 'umrah_transport_cities.id')
            ->join('umrah_transport_cities As C', 'agent_umrah_transport_details.to_city', 'C.id')
            ->select('agent_umrah_transport_details.*', 'umrah_transport_cities.name as from_city', 'C.name AS to_city')
            ->where('agent_umrah_transport_details.UID', $id)->get();
        $hotels=DB::table('agent_umrah_hotel_details')
            ->join('cities', 'agent_umrah_hotel_details.city','cities.id')
            ->join('hotels', 'agent_umrah_hotel_details.hotel_id','hotels.id')
            ->select('agent_umrah_hotel_details.*', 'hotels.name AS hotel_name','cities.name AS city_name')->where('UID', $id)->get();
        $pax=DB::table('agent_umrah_pax_details')
            ->join('countries','agent_umrah_pax_details.nationality', 'countries.id')
            ->select('agent_umrah_pax_details.*','countries.name')->where('UID', $id)->get();
        $agent=Agent::where('UID',$flight->created_by)->first();
        $ground_hand_comp=GroundHandleRate::where('id',$flight->ground_handle_product)->value('comp_name');
        $family_head=AgentUmrahPaxDetail::where(['UID'=>$id, 'group_leader'=>1])->value('pax_name');
        $group_details=DB::table('group_details')->where('id',$flight->group_no)->first();
        $data=compact('flight','agent', 'transport','hotels','pax',
            'ground_hand_comp','family_head','group_details');
        view()->share('data', $data);;
        $pdf= PDF::loadView('agents.agent_booking.umrah_voucher', $data);
        return Storage::put('public/umrah_voucher/invoice_'.$id.'.pdf', $pdf->output());
    }
    /*
     * fetch groups accordingly agents
     */
    public function fetch_agent_group($id){
        $result=GroupDetail::where('agentID',$id)->
            whereBetween('created_at',[Account::financial_year()])->get();
        return $result;
    }
    public function get_agent_hotel($id, $city){
        return Hotel::agentHotel($id, $city);
    }
}
