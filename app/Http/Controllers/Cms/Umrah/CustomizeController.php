<?php

namespace App\Http\Controllers\Cms\Umrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Cms\Umrah\CustomizePackage;
use Auth;

class CustomizeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:umrah_custom_packages_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.umrah.customize.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.umrah.customize.create');
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
            'price'=>'required',
            'makkah_hotel'=>'required',
            'madina_hotel'=>'required',
            'duraion'=>'required',
            'makkah_night'=>'required',
        ];
        $message=[
            'pkg_name.required'=>'Package Name Required',
            'price.required'=>'Price Required',
            'makkah_hotel.required'=>'Makkah Hotel Required',
            'madina_hotel.required'=>'Madina Hotel Required',
            'duration.required'=>'Duration Required',
            'makkah_night.required'=>'Makkah Nights Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','pkg_images']);
        $himgs='';
        if(isset($request->pkg_images)) {
            foreach ($request->pkg_images as $hotel_image) {
                $himgs .= url('storage/app/' . $hotel_image->store('public/umrah/pkg_images')) . ',';
            }
            $data['pkg_images'] = ltrim($himgs,',');
        }
        if(isset($request->brochure_image)) {
            foreach ($request->brochure_image as $hotel_image) {
                $himgs .= url('storage/app/' . $hotel_image->store('public/umrah/brochures')) . ',';
            }
            $data['brochure_image'] = ltrim($himgs,',');
        }
        $id=$request->id;
        DB::beginTransaction();
        try {
               $data['created_by']=Auth::user()->id;
               CustomizePackage::create($data);
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
    //@display data in list
    public function get_data(Request $request){
        return CustomizePackage::paginate(15);
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
        $data=CustomizePackage::find($id);
        return view('cms.umrah.customize.edit',compact('data'));
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
            'price'=>'required',
            'makkah_hotel'=>'required',
            'madina_hotel'=>'required',
            'duraion'=>'required',
            'makkah_night'=>'required',
        ];
        $message=[
            'pkg_name.required'=>'Package Name Required',
            'price.required'=>'Price Required',
            'makkah_hotel.required'=>'Makkah Hotel Required',
            'madina_hotel.required'=>'Madina Hotel Required',
            'duraion.required'=>'Duration Required',
            'makkah_night.required'=>'Makkah Nights Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','pkg_images','brochure_image','_method']);
        $himgs='';
        $bimgs='';
        if(isset($request->pkg_images)) {
            foreach ($request->pkg_images as $hotel_image) {
                $himgs .= url('storage/app/' . $hotel_image->store('public/umrah/pkg_images')) . ',';
            }
            $data['pkg_images'] = rtrim($himgs,',');
        }
        if(isset($request->brochure_image)) {
            $img=$request->brochure_image;
                $bimgs .= url('storage/app/' . $img->store('public/umrah/brochures'));
            $data['brochure_image'] =$bimgs;
        }
        DB::beginTransaction();
        try {
            CustomizePackage::where('id', $id)->update($data);
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
        //
    }
}
