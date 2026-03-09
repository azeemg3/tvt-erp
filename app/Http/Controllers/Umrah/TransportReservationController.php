<?php

namespace App\Http\Controllers\Umrah;

use App\Http\Controllers\Controller;
use App\Models\Umrah\HotelReservationBrn;
use App\Models\Umrah\TransportBrnSector;
use App\Models\Umrah\TransportReservationBrn;
use App\Models\UmrahTransportCity;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Helpers\Account;
class TransportReservationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transport_reservation_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('umrah.reservations.transport_reservation.index');
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
            'brn'=>'required',
            'booking_date'=>'required',
            'purchased_by'=>'required',
        ];
        $message=[
            'brn.required'=>'BRN Required',
            'booking_date.required'=>'Booking Date Required',
            'purchased_by.required'=>'Purchased By Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','from_city','to_city','sector_date','sector_time']);
        $count=count($request->from_city);
        $id=$request->id;
        if(!empty($request['from_city'][0])) {
            for ($j = 0; $j < $count; $j++) {
                if (!empty($request->from_city[$j])) {
                    $aarray[] = [
                        "from_city" => UmrahTransportCity::where('id', $request->from_city[$j])->value('name'),
                        "to_city" => UmrahTransportCity::where('id', $request->to_city[$j])->value('name'),
                        "sector_date" => $request->sector_date[$j],
                        "sector_time" => $request->sector_time[$j],
                    ];
                }
            }
            $data['sector_details'] = json_encode($aarray, true);
        }
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=TransportReservationBrn::create($data);
                $TRBID=$ret->id;
            } else {
                TransportReservationBrn::where('id', $id)->update($data);
                $ret=$id;
                $TRBID=$id;
            }
            //add sector detils
            TransportBrnSector::where('TRBID',$id)->delete();
            if(isset($request->form_city) && !empty($request->form_city)) {
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($request->from_city[$i])) {
                        $array[] = [
                            "from_city" => $request->from_city[$i],
                            "to_city" => $request->to_city[$i],
                            "sector_date" => $request->sector_date[$i],
                            "sector_time" => $request->sector_time[$i],
                            "TRBID" => $TRBID,
                        ];
                    }
                }
                TransportBrnSector::insert($array);
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
    //@dispaly data in list
    public function get_data(Request $request){
        $result=TransportReservationBrn::with(['sectors','source','trans_comp','trans_route','trans_brn'])
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->orderBy('id','DESC')->paginate(50);
//        $result=DB::table('transport_reservation_brns AS t')
//            ->leftjoin('transport_brn_sectors AS tbs', 't.id','tbs.TRBID')
//            ->leftjoin('transaction_accounts AS trans', 't.purchased_by','trans.id')
//            ->leftjoin('transport_companies AS tc', 't.transport_co','tc.id')
//            ->paginate(50);
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
        $result=TransportReservationBrn::find($id);
        $secDet=TransportBrnSector::where('TRBID',$id)->get();
       $array=json_decode($secDet,true);
       if($array==null) {
           $count=0;
       }else{
           $count=count($array);
       }
       $htmlData='';
       for($i=0; $i<$count; $i++){
          $htmlData.='<div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sector From</label>
                                <select name="from_city[]" class="form-control form-control-sm select2">
                                    <option value="">From City</option>
                                    '.UmrahTransportCity::dropdown($array[$i]['from_city']).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">To City</label>
                                <select name="to_city[]" class="form-control form-control-sm select2">
                                    <option value="">Select Sector</option>
                                    '.UmrahTransportCity::dropdown($array[$i]['to_city']).'
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Date</label>
                            <input type="text" name="sector_date[]" class="form-control form-control-sm date" value="'.date('Y-m-d',strtotime($array[$i]['sector_date'])).'" placeholder="Date">
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Time</label>
                            <input type="time" name="sector_time[]" value="'.$array[$i]['sector_time'].'" class="form-control form-control-sm">
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden" for="exampleInputEmail1">Sector From</label>
                                <button type="button" onclick="more_transport_sector()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->';
        }
       return compact('result','htmlData');
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
