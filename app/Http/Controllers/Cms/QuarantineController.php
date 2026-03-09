<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Quarantine;
use Illuminate\Http\Request;
use DB;
use Auth;
use Store;

class QuarantineController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:quarantine_packages_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.quarantine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.quarantine.create');
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
            'country_id'=>'required',
            'city_id'=>'required',
            'airline_id'=>'required',
            'inclusions'=>'required',
            'pkg_details'=>'required',
            'quarantine_information'=>'required',
        ];
        $message=[
            'country_id.required'=>'Country Name Required',
            'city_id.required'=>'City Name Required',
            'airline_id.required'=>'Airline Required',
            'inclusions.required'=>'Inclusion Required',
            'pkg_details.required'=>'Package Details Required',
            'quarantine_information.required'=>'Quarantine Information Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','hotel_images','transport_image']);
        $himgs='';
        if(isset($request->hotel_images)) {
            foreach ($request->hotel_images as $hotel_image) {
                $himgs .= url('storage/app/' . $hotel_image->store('public/quarantine/hotel_images')) . ',';
            }
            $data['hotel_images'] = $himgs;
        }
        if(isset($request->transport_image)) {
            $transport_img =$request->transport_image->store('public/quarantine/transport');
            $data['transport_image'] = url('storage/app/' . $transport_img);
        }
        $data['inclusions']=implode(',',$request->inclusions);
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret = Quarantine::create($data);
            } else {
                $ret = Quarantine::where('id', $id)->update($data);
            }
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
    //@diplay data in list
    public function get_data(){
        return Quarantine::with('city')->paginate(15);
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
        $result=Quarantine::find($id);
        return view('cms.quarantine.edit')->with(compact('result'));
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
