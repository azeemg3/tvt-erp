<?php

namespace App\Http\Controllers\Umrah;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\Transaction;
use App\Models\Crm\AgentUmrahPaxDetail;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Umrah\AgentUmrahVisitor;
use App\Models\Umrah\GroundService;
use App\Models\Umrah\GroupDetail;
use App\Models\Umrah\GroupGroundService;
use App\Models\Umrah\GroupVoucher;
use App\Models\Umrah\GVHotel;
use App\Models\Umrah\GvOtherService;
use App\Models\Umrah\GvTransport;
use App\Models\Umrah\HotelBrn;
use App\Models\Umrah\HotelReservationBrn;
use App\Models\Umrah\TransportBrn;
use App\Models\Umrah\TransportCompany;
use App\Models\Umrah\TransportReservationBrn;
use function Google\Auth\Cache\currentTime;
use Illuminate\Http\Request;
use DB;
use Auth;
use Store;
use Validator;
use App\Imports\GroupDetailImport;
use App\Imports\GroupVisitorImport;
use Excel;

class GroupDetailController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:umrah_group_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('umrah.group_details.index');
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
            'agentID'=>'required',
            'country'=>'required',
            'group_code'=>'required',
            'group_name'=>'required',
        ];
        $message=[
            'agentID.required'=>'Agent Required',
            'country.required'=>'Country Required',
            'group_code.required'=>'Group Code Required',
            'group_name.required'=>'Group Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token']);
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $sData['created_by']=Auth::user()->id;
                GroupDetail::create($data);
            } else {
                GroupDetail::where('id', $id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //@display data in list
    public function get_data(Request $request){
        $result=DB::table('group_details AS g')
            ->leftjoin('agents AS a','g.agentID','a.id')
            ->leftjoin('countries AS c','g.country','c.id')
            ->leftjoin('agent_umrah_visitors AS v','g.id','v.group_id')
            ->leftjoin('group_vouchers AS gv','g.id','gv.GID')
            ->select('g.*','a.agent_name','c.name As country_name',
                DB::raw('(SELECT IFNULL(count(h.id),0)
            FROM hotel_brns h WHERE h.GRID=g.id) AS total_hotelBrn'),
                DB::raw('(SELECT IFNULL(count(t.id),0)
            FROM transport_brns t WHERE t.GRID=g.id) AS total_transBrn'),
                DB::raw('(SELECT count(*)
            FROM agent_umrah_visitors m WHERE m.group_id=g.id AND m.mofa!="null") AS total_mofa'),
                DB::raw('(select count(id) from agent_umrah_visitors where group_id=g.id and linked=1) AS linked_pax'),
                DB::raw('count(v.id) AS total_visitors'),
                DB::raw('(SELECT IFNULL(count(gg.id),0)
            FROM group_ground_services gg WHERE gg.group_id=g.id) AS total_gs'),
                'gv.voucher','gv.total_amount')
            ->whereBetween(DB::raw('DATE(g.created_at)'),Account::financial_year())
            ->when($request->group_code, function ($query) use ($request){
                $query->where('g.group_code',$request->group_code);
            })->when($request->group_name, function ($query) use ($request){
                $query->where('g.group_name','LIKE','%'.$request->group_name.'%');
            })->when($request->agentID, function ($query) use ($request){
                $query->where('g.agentID',$request->agentID);
            })
            ->groupBy('group_code')->orderBy('id','DESC')->paginate(50);
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
        return GroupDetail::find($id);
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
    //save visitors
    public function save_visitor(Request $request){
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
        $data['group_id']=$request->group_id;
        $id=$request->id;
        $cnic_photo='';
        if(isset($request->cnic_photos)) {
            foreach ($request->cnic_photos as $photo) {
                $cnic_photo.=url('/storage/app/'.$photo->store('public/umrah/cnic')).',';
            }
            $cnic_photo=rtrim($cnic_photo,',');
        }
        $passport_photos='';
        if(isset($request->passport_photos)) {
            foreach ($request->passport_photos as $passport_photo) {
                $passport_photos.=url('/storage/app/'.$passport_photo->store('public/umrah/passport')).',';
            }
            $passport_photos=rtrim($cnic_photo,',');
        }
        $vaccine_card_photo='';
        if(isset($request->vaccine_card_photo)) {
            $vaccine_card_photo=url('/storage/app/'.$request->vaccine_card_photo->store('public/umrah/vaccine'));
        }
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                AgentUmrahVisitor::create($data);
            } else {
                AgentUmrahVisitor::where('id', $id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }catch (\Illuminate\Database\QueryException $e) {
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code' => $e->errorInfo,
            ], 400);
            DB::rollback();
        }

    }
    //remove visitors
    function remove_visitor($id){
        return AgentUmrahVisitor::destroy($id);
    }
    //get get_visitor_data
    public function get_visitor_data(Request $request){
        $result=AgentUmrahVisitor::with(['country'])->where('group_id', $request->GID)->get();
        return response()->json($result);
    }
    //@edit umrah pax
    public function edit_pax($id){
        return AgentUmrahVisitor::find($id);
    }
    //@save mofa detials
    public function save_mofa_details(Request $request){
        $data=$request->except(['token','visa_attachment']);
        $id=$request->id;
        if(isset($request->visa_attachment) && $request->visa_attachment!='undefined') {
            $visa_attachment=url('/storage/app/'.$request->visa_attachment->store('public/umrah/visa_attachment'));
            $data['visa_attachment']=$visa_attachment;
        }
        DB::beginTransaction();
        try {
            AgentUmrahVisitor::where('id', $id)->update($data);
            DB::commit();
            $ret=AgentUmrahVisitor::find($id);
            return response()->json($ret);
        }catch (\Illuminate\Database\QueryException $e) {
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code' => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //save hotel brn
    public function save_hotelbrn(Request $request){
        $rules=[
            'HTBRN'=>'required',
        ];
        $message=[
            'HTBRN.required'=>'Hotel Brn Required',
        ];
        $this->validate($request, $rules, $message);
        $id=$request->id;
        $count=count($request->HTBRN);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                for($i=0; $i<$count; $i++){
                    if(!empty($request['HTBRN'][$i])) {
                        $array= ['HTBRN' => $request['HTBRN'][$i], 'no_pax' => $request['no_pax'][$i],
                            'GRID' => $request->GID];
                        HotelBrn::create($array);
                    }
                }
                DB::commit();
                return HotelBrn::where('GRID', $request->GID)->sum('no_pax');
            } else {
//                HotelBrn::where('id', $id)->update($array);
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
    //edit hotel brn
    public function edit_hotelBrn($id){
        $hotelBrn='';
        $total_pax=AgentUmrahVisitor::where('group_id', $id)->count();
        $result=HotelBrn::where('GRID',$id)->get();
        foreach ($result as $item){
            $hotelBrn.='<div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="HTBRN[]" class="form-control form-control-sm select2" id="" onchange="hotel_reservation(this), available_hotel_capacity(this)">
                                    <option value="">--Select--</option>
                                    '.HotelReservationBrn::dropdown($item->HTBRN).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                            <select name="" readonly class="form-control form-control-sm room_type" id="" onchange="hotel_reservation(this.value), available_hotel_capacity(this)">
                            <option value="">--Select--</option>
                                '.RoomType::dropdown().'
                            </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                            <input type="text" readonly class="form-control form-control-sm no_room" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="text" readonly class="form-control form-control-sm no_beds" placeholder="Enter...">
                            </div>
                         </div>
                         <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <input  type="text" name="no_pax[]" value="'.$item->no_pax.'" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" onclick="more_hotel_brn()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>';
            }
            return compact('hotelBrn','total_pax');
    }
    //save hotel brn
    public function save_transportbrn(Request $request){
//        $rules=[
//            'TRBRN.*'=>'required',
//            'no_pax.*'=>'required',
//        ];
//        $message=[
//            'TRBRN.required'=>'Pax Name Required',
//            'no_pax.required'=>'Please Enter No of Pax',
//        ];
//        $this->validate($request, $rules, $message);
        $id=$request->id;
        $count=count($request->TRBRN);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                for($i=0; $i<$count; $i++){
                    if(!empty($request['TRBRN'][$i])) {
                        $array = ['TRBRN' => $request['TRBRN'][$i], 'no_pax' => $request['no_pax'][$i],
                            'GRID' => $request->GID];
                        TransportBrn::create($array);
                    }
                }
                DB::commit();
                return TransportBrn::where('GRID', $request->GID)->sum('no_pax');
            } else {
//                HotelBrn::where('id', $id)->update($array);
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
    //edit transport brn
    public function edit_transportBrn($id){
        $hotelBrn='';
        $result=TransportBrn::where('GRID',$id)->get();
        foreach ($result as $item){
            $hotelBrn.='<div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <select name="TRBRN[]" class="form-control form-control-sm select2" id="fetch_hotel_brn" onchange="hotel_reservation(this.value), available_capacity(this)">
                                    <option value="">--Select--</option>
                                    '.TransportReservationBrn::dropdown($item->TRBRN).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <input readonly type="text"  class="form-control form-control-sm available" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <input  type="text" name="no_pax[]" value="'.$item->no_pax.'" class="form-control form-control-sm no_pax" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" onclick="more_trans_brn()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>';
        }
        return compact('hotelBrn');
    }
    //save groups services
    public function save_group_service(Request $request){
        $rules=[
            'service_id.*'=>'required',
            'no_pax.*'=>'required',
        ];
        $message=[
            'service_id.required'=>'Service Required',
            'no_pax.required'=>'Pax Name Required',
        ];
        $this->validate($request, $rules, $message);
        $id=$request->id;
        $count=count($request->service_id);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                for($i=0; $i<$count; $i++){
                    $array[]=['service_id'=>$request['service_id'][$i], 'no_pax'=>$request['no_pax'][$i],
                        'group_id'=>$request->GID];
                }
                GroupGroundService::insert($array);
                DB::commit();
                return GroupGroundService::where('group_id', $request->GID)->sum('no_pax');
            } else {
//                HotelBrn::where('id', $id)->update($array);
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
    //save umrah voucher details
    public function save_group_voucher(Request $request){
        $rules=[
            'voucher'=>'required',
            'GID'=>'required',
        ];
        $message=[
            'voucher.required'=>'Voucher Number Required',
            'GID.required'=>'Group ID Required',
        ];
        $this->validate($request, $rules, $message);
        $id=$request->id;
        $data['status'] =1;
        $data['currency'] =$request->currency;
        $data['currency_rate']=$request->currency_rate;
        $data['voucher'] = $request->voucher;
        $data['GID'] = $request->GID;
        $data['total_amount'] = $request->grand_total;
        DB::beginTransaction();
        try {
            if($id==0 || $id=='') {
                $trans_code=Account::trans_code();
                $data['trans_code']=$trans_code;
                $ret = GroupVoucher::create($data);
            }else{
                GroupVoucher::where('id',$id)->update($data);
                $ret=GroupVoucher::find($id);
                $trans_code=$ret->trans_code;
            }
            GVHotel::where('GVID',$id)->delete();
            Transaction::where('trans_code',$trans_code)->delete();
            $hCount = count($request->brn);
            for ($i = 0; $i < $hCount; $i++) {
                if (isset($request['brn'][$i]) && !empty($request['brn'][$i])) {
                    $hArray= array('brn' => $request['brn'][$i], 'hotel_id' => $request['hotel_id'][$i],
                        'service_date' => $request['service_date'][$i], 'price' => $request['price'][$i],
                        'qty' => $request['qty'][$i], 'total_amount' => $request['total_amount'][$i],'GVID'=>$ret->id);
                    //accounts entry
                    $transaction=[
                        'amount'=>$request['total_amount'][$i]*$request->currency_rate,
                        'dr_cr'=>2,
                        'trans_code'=>$trans_code,
                        'vt'=>2,
                        'trans_acc_id'=>HotelReservationBrn::where('brn', ''.$request['brn'][$i].'')->first()->purchased_by,
                        'trans_date'=>date('Y-m-d'),
                        'narration'=>'Create Payment Voucher againt Brn:('.!empty($request['brn'][$i]).') Ref:'.$request->voucher.'',
                        'status'=>1,
                        'created_by'=>Auth::user()->id,
                        'currency'=>$request->currency,
                        'conversion_rate'=>$request->currency_rate,
                        'created_at'=>date('Y-m-d h:i:s'),
                    ];
                    GVHotel::insert($hArray);
                    Transaction::insert($transaction);
                }
            }
            //transport details
            GvTransport::where('GVID',$id)->delete();
            $tCount = count($request->tbrn);
            for ($j = 0; $j < $tCount; $j++) {
                if (!empty($request['tbrn'][$j])) {
                    $tArray = ['brn' => $request['tbrn'][$j], 'TCID' => $request['transport_comp'][$j],
                        'service_date' => $request['tservice_date'][$j], 'price' => $request['tprice'][$j],
                        'qty' => $request['tqty'][$j], 'total_amount' => $request['ttotal_amount'][$j], 'GVID' =>$ret->id];
                    $transaction_transport=[
                        'amount'=>$request['ttotal_amount'][$j]*$request->currency_rate,
                        'dr_cr'=>2,
                        'trans_code'=>$trans_code,
                        'vt'=>2,
                        'trans_acc_id'=>HotelReservationBrn::where('brn', ''.$request['brn'][$j].'')->first()->purchased_by,
                        'trans_date'=>date('Y-m-d'),
                        'narration'=>'Create Payment Voucher againt Brn:('.!empty($request['brn'][$j]).') Ref:'.$request->voucher.'',
                        'status'=>1,
                        'created_by'=>Auth::user()->id,
                        'currency'=>$request->currency,
                        'conversion_rate'=>$request->currency_rate,
                        'created_at'=>date('Y-m-d h:i:s'),
                    ];
                    GvTransport::insert($tArray);
                    Transaction::create($transaction_transport);
                }
            }
            //other services
            GvOtherService::where('GVID',$id)->delete();
            $oCount = count($request->Oservice_name);
            for ($k = 0; $k< $oCount; $k++) {
                if (isset($request['Oservice_name'][$k]) && !empty($request['Oservice_name'][$k])) {
                    $oArray= ['service_name' => $request['Oservice_name'][$k], 'price' => $request['Oprice'][$k],
                        'qty' => $request['Oqty'][$k], 'total_amount' => $request['Ototal_amount'][$k], 'GVID' => $ret->id];
                    //accounts entry
                    $transaction_other=[
                        'amount'=>$request['Ototal_amount'][$k]*$request->currency_rate,
                        'dr_cr'=>2,
                        'trans_code'=>$trans_code,
                        'vt'=>2,
                        'trans_acc_id'=>GroundService::where('id', $request['Oservice_name'][$k])->first()->purchased_by,
                        'trans_date'=>date('Y-m-d'),
                        'narration'=>'Create Payment Voucher Ref:'.$request->voucher.'',
                        'status'=>1,
                        'created_by'=>Auth::user()->id,
                        'currency'=>$request->currency,
                        'conversion_rate'=>$request->currency_rate,
                        'created_at'=>date('Y-m-d h:i:s'),
                    ];
                    GvOtherService::insert($oArray);
                    Transaction::create($transaction_other);
                }
            }
            DB::commit();
            return $ret;
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }

    }
    //@edit group voucher amount etc.
    public function edit_gv($id){
        $result=GroupVoucher::where('GID',$id)->first();
        $htmlHotel = '';
        $transportHtml='';
        $otherHtml='';
        $hotelBrn=HotelBrn::group_hotel_brn($id);
        $transportBrn=TransportBrn::group_transport_brn($id);
        $otherServices=GroupGroundService::group_gs($id);
        if($result) {
            $GVID = $result->id;
            $hotels = GVHotel::where('GVID', $GVID)->get();
            foreach ($hotels as $hotel) {
                $htmlHotel .= '<tr>
                        <td><select name="brn[]" class="form-control form-control-sm">
                        <option value="">Add New</option>
                        ' . HotelBrn::group_hotel_brn($id, $hotel->brn) . '
                        </select>
                        </td>
                        <td>
                        <select class="form-control form-control-sm select2 hotel_id" name="hotel_id[]">
                        <option value="">Select Hotel</option>
                            ' . Hotel::dropdown($hotel->hotel_id) . '
                        </select>
                        </td>
                        <td><input type="text" name="service_date[]" value="' . $hotel->service_date . '" class="form-control form-control-sm date" placeholder="srevice date"></td>
                        <td><input type="text" name="price[]"  value="' . $hotel->price . '" class="form-control form-control-sm price" placeholder="Price"></td>
                        <td><input type="text" name="qty[]" value="' . $hotel->qty . '" class="form-control form-control-sm qty" placeholder="Qty"></td>
                        <td><input type="text" name="total_amount[]" value="' . $hotel->total_amount . '" class="form-control form-control-sm total" placeholder="Amount"></td>
                        <td><button type="button" class="btn btn-info btn-sm" onclick="more_hotel_gv(this)"><i class="fa fa-plus"></i> </button></td>
                        </tr>';
            }
            $transports = GvTransport::where('GVID', $GVID)->get();
            $transportHtml = '';
            foreach ($transports as $transport) {
                $transportHtml .= '<tr>
                            <td>
                            <select name="tbrn[]" class="form-control form-control-sm">
                             <option value="">Add New</option>
                             ' . TransportBrn::group_transport_brn($id, $transport->brn) . '
                            </select>
                            </td>
                            <td><select name="transport_comp[]" class="form-control form-control-sm">
                                    <option value="">Select Company</option>
                                    ' . TransportCompany::dropdown($transport->TCID) . '
                                </select>
                            </td>
                            <td><input name="tservice_date[]" value="' . $transport->service_date . '" type="text" class="form-control form-control-sm date" placeholder="srevice date"></td>
                            <td><input type="text" name="tprice[]" value="' . $transport->price . '" class="form-control form-control-sm price" placeholder="Price"></td>
                            <td><input type="text" name="tqty[]" value="' . $transport->qty . '" class="form-control form-control-sm qty" placeholder="Qty"></td>
                            <td><input type="text" name="ttotal_amount[]" value="' . $transport->total_amount . '" class="form-control form-control-sm total" placeholder="Amount"></td>
                            <td><button type="button" class="btn btn-info btn-sm" onclick="more_transport_gv(this)"><i class="fa fa-plus"></i> </button></td>
                        </tr>';
            }
            $others = GvOtherService::where('GVID', $GVID)->get();
            $otherHtml = '';
            foreach ($others as $other) {
                $otherHtml .= '<tr>
                            <td>
                                <select name="Oservice_name[]" id="" class="form-control form-control-sm">
                                    <option value="">Select Services</option>
                                    '.GroupGroundService::group_gs($id, $other->service_name).'
                                </select>
                            </td>
                            <td><input type="text" value="' . $other->price . '" name="Oprice[]" class="form-control form-control-sm price" placeholder="Price"></td>
                            <td><input type="text" value="' . $other->qty . '" name="Oqty[]" class="form-control form-control-sm qty" placeholder="Qty"></td>
                            <td><input type="text" value="' . $other->total_amount . '" name="Ototal_amount[]" class="form-control form-control-sm total" placeholder="Amount"></td>
                            <td><button type="button" class="btn btn-info btn-sm" onclick="more_os_gv()"><i class="fa fa-plus"></i> </button></td>
                        </tr>';
            }
        }
        return compact('result','htmlHotel','transportHtml','otherHtml','hotelBrn','transportBrn','otherServices');
    }
    //edit group groudn services
    public function edit_gground_service($id)
    {
        $ggsHtml = '';
        $adult=AgentUmrahVisitor::where('pax_type',1)->where('group_id',$id)->count();
        $child=AgentUmrahVisitor::where('pax_type',2)->where('group_id',$id)->count();
        $infant=AgentUmrahVisitor::where('pax_type',3)->where('group_id',$id)->count();
        $result = GroupGroundService::where('group_id', $id)->get();
        foreach ($result as $item) {
            $ggsHtml .= '<div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Services</label>
                                <select name="service_id[]" class="form-control form-control-sm select2" id="fetch_gs" onchange="add_new_gs_det(this.value)">
                                    <option value="">--Select Service--</option>
                                    <option value="new">Add New</option>
                                    {!! App\Models\Umrah\GroundService::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#of Pax</label>
                                <input type="text" name="no_pax[]" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                    </div>';
        }
        return compact('ggsHtml','adult','child','infant');
    }
    //save data in excel
    public function save_group_excel(Request $request){
        $rules=[
            'import_file'=>'required|mimes:xlsx,csv, xls',
        ];
        $message=[
            'import_file.required'=>'File Required',
        ];
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        try {
            if($request->hasFile('import_file')) {
                $file = $request->file('import_file');
                Excel::import(new GroupDetailImport(), $file);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
        }
    }
    //===============save visiotr excel file====
    public function save_visitor_excel(Request $request){
        $rules=[
            'visiotr_file'=>'required|mimes:xlsx,csv, xls',
        ];
        $message=[
            'visiotr_file.required'=>'File Required',
        ];
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        try {
            if($request->hasFile('visiotr_file')) {
                $file = $request->file('visiotr_file');
                Excel::import(new GroupVisitorImport(), $file);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
        }
    }
    //@fetch available capacity
    public function fetch_available_capacity($brn){
        $total_capacity=TransportReservationBrn::where('id', $brn)->first();
        //used for visa purpose
        $used=TransportBrn::where('TRBRN', $brn)->sum('no_pax');
        $available=$total_capacity->total_capacity-$used;
        return compact('available');
    }
    //@fetch available capacity for hotel
    public function fetchHotel_available_capacity($brn){
        $total_capacity=HotelReservationBrn::where('id', $brn)->first();
        //used for visa purpose
        $used=HotelBrn::where('HTBRN', $brn)->sum('no_pax');
        $available=$total_capacity->total_capacity-$used;
        return compact('total_capacity','available');
    }
}
