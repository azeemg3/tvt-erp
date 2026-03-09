<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:hotel_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Setup.hotels.index');
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
            'name'=>'required',
            'country'=>'required'
        ];
        $message=[
            'name.required'=>'Hotel Name required',
            'country.required'=>'Country required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','hotel_address']);
        $data['hotel_address']=$request->hotel_address;
        $id=$request->id;
        if($id==0 || $id==''){
            return Hotel::create($data);
        }else{
            Hotel::where('id', $id)->update($data);
        }
        return response()->json(['success'=>'Added new record Successfully.']);
    }
    //@fetch hotel list
    public function get_data(Request $request){
        return Hotel::with('country')->orderByDesc('id')->paginate(15);
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
        return Hotel::find($id);
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
        return Hotel::destroy($id);
    }
}
