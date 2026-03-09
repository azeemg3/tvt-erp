<?php

namespace App\Http\Controllers\Tours;

use App\Http\Controllers\Controller;
use App\Models\Tours\IntTour;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Bookings\TourBooking;
class IntTourController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:tour_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.Tours.tour.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.Tours.tour.create');
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
            'pkg_name'=>'required',
            'country_id'=>'required',
            'explore_details'=>'required',
        ];
        $message=[
            'pkg_name.required'=>'Package Name required',
            'country_id.required'=>'Country required',
            'explore_details.required'=>'Explore Detail required',
        ];
        $this->validate($request,$rules, $message);
        $data=$request->except(['_token']);
        $countInfo=count($request->title);
        for($i=0; $i<$countInfo; $i++){
            $info[]=[
                'title'=>$request['title'][$i],
                'info_detail'=>$request['info_detail'][$i],
            ];
        }
        //for transport price detials
        $countTransport=count($request->transport_city);
        for($j=0; $j<$countTransport; $j++){
            $transport[]=[
                'city'=>$request['transport_city'][$j],
                'transport'=>$request['transport'][$j],
                'sector'=>$request['sector'][$j],
                'transport_rate'=>$request['transport_rate'][$j],
                'vendor'=>$request['t_purchased_by'][$j],
            ];
        }
        //for hotel price details
        $countHotel=count($request->hotel_name);
        for($k=0; $k<$countHotel; $k++){
            $hotel[]=[
                'hotel_city'=>$request['hotel_city'][$k],
                'hotel_name'=>$request['hotel_name'][$k],
                'category'=>$request['category'][$k],
                'room_type'=>$request['room_type'][$k],
                'room_rate'=>$request['room_rate'][$k],
                'vendor'=>$request['h_purchased_by'][$k],
            ];
        }
        $data['your_info']=json_encode($info,true);
        $data['transports']=json_encode($transport, true);
        $data['hotels']=json_encode($hotel,true);
        $validity=$request->traveling_dt;
        $validity=explode('/',$validity);
        $data['validity_from']=$validity[0];
        $data['validity_to']=$validity[1];
        DB::beginTransaction();
        $id=$request->id;
        $pgkImg='';
        if(isset($request->pkg_images)) {
            foreach ($request->pkg_images as $pkg_image) {
                $img=$pkg_image->getClientOriginalName();
                $pgkImg .= url('storage/app/' . $pkg_image->storeAs('public/tour', $img)) . ',';
            }
            rtrim($pkg_image,",");
            $data['pkg_images'] = $pgkImg;
        }
        try{
            //if($id==0 || $id==''){
                IntTour::create($data);
            DB::commit();
            return back()->with('success','Package created successfully');
            //}
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }

    }
    //@display data in list
    public function get_data(Request $request){
        $result=IntTour::with(['country'])->paginate(50);
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
        $result=IntTour::where('id',$id)->first();
        return view('cms.Tours.tour.show',compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=IntTour::find($id);
        return view('cms.Tours.tour.edit',compact('result'));
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
        $rules=[
            'pkg_name'=>'required',
            'country_id'=>'required',
            'explore_details'=>'required',
        ];
        $message=[
            'pkg_name.required'=>'Package Name required',
            'country_id.required'=>'Country required',
            'explore_details.required'=>'Explore Detail required',
        ];
        $this->validate($request,$rules, $message);
        $data=$request->except(['_token','_method','traveling_dt','title','info_detail','v_purchased_by','t_purchased_by',
            'transport_city','transport','sector','transport_rate','h_purchased_by','hotel_city','hotel_name','category',
            'room_type','room_rate']);
        $countInfo=count($request->title);
        for($i=0; $i<$countInfo; $i++){
            $info[]=[
                'title'=>$request['title'][$i],
                'info_detail'=>$request['info_detail'][$i],
            ];
        }
        //for transport price detials
        $countTransport=count($request->transport_city);
        for($j=0; $j<$countTransport; $j++){
            $transport[]=[
                'city'=>$request['transport_city'][$j],
                'transport'=>$request['transport'][$j],
                'sector'=>$request['sector'][$j],
                'transport_rate'=>$request['transport_rate'][$j],
                'vendor'=>$request['t_purchased_by'][$j],
            ];
        }
        //for hotel price details
        $countHotel=count($request->hotel_name);
        for($k=0; $k<$countHotel; $k++){
            $hotel[]=[
                'hotel_city'=>$request['hotel_city'][$k],
                'hotel_name'=>$request['hotel_name'][$k],
                'category'=>$request['category'][$k],
                'room_type'=>$request['room_type'][$k],
                'room_rate'=>$request['room_rate'][$k],
                'vendor'=>$request['h_purchased_by'][$k],
            ];
        }
        $data['your_info']=json_encode($info,true);
        $data['transports']=json_encode($transport, true);
        $data['hotels']=json_encode($hotel,true);
        $validity=$request->traveling_dt;
        $validity=explode('/',$validity);
        $data['validity_from']=$validity[0];
        $data['validity_to']=$validity[1];
        DB::beginTransaction();
        $pgkImg='';
        if(isset($request->pkg_images)) {
            foreach ($request->pkg_images as $pkg_image) {
                $img=$pkg_image->getClientOriginalName();
                $pgkImg .= url('storage/app/' . $pkg_image->storeAs('public/tour', $img)) . ',';
            }
            rtrim($pkg_image,",");
            $data['pkg_images'] = $pgkImg;
        }
        try{
            DB::connection()->enableQueryLog();
            $ret=IntTour::where('id',$id)->update($data);
            $queries = DB::getQueryLog();
            DB::commit();
            return back()->with('success','Package created successfully');
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
        return IntTour::destroy($id);
    }
    //@apporved agent created packages
    public function apporve($id){
        IntTour::where('id',$id)->update(['status'=>1]);
        $status=IntTour::find($id)->value('status');
        return $status;
    }
}
