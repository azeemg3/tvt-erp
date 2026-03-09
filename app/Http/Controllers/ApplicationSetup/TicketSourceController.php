<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketSource;

class TicketSourceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ticket_source_view', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Setup.ticket_sources.index');
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
        ];
        $mesage=[
            'name.required'=>'Ticket Source required',
        ];
        $this->validate($request, $rules, $mesage);
        $id=$request->id;
        $data=request()->except(['_token']);
        if($id==0 || $id==''){
            $ret=TicketSource::create($data);
        }else{
            $ret=TicketSource::where('id', $id)->update($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    //@dispay the listing data
    public function get_data(Request $request){
        return TicketSource::orderByDesc('id')->get();
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
        return TicketSource::find($id);
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
