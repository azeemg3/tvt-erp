<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use DB;
class HotelRoomType extends Controller
{
    function __construct()
    {
        $this->middleware('permission:room_type_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Setup.hotel_rooms.index');
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
        $rules = [
            'name' => 'required',
        ];
        $message=[
            'name.required'=>'Room Type Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $ret = RoomType::create($data);
                return $ret;
            } else {
                $ret = RoomType::where('id', $id)->update($data);
                DB::commit();
                return $ret;
            }
        }catch (QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollBack();
        }
    }
    //@display data in list
    public function get_data(Request $request){
        return RoomType::paginate(50);
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
        return RoomType::find($id);
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
