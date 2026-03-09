<?php

namespace App\Http\Controllers\Agents;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class UmrahDraftController extends Controller
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
        return view('agents.umrah_draft.index');
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
        //
    }
    //dispaly data in list
    public function get_data(Request $request){
        $res=DB::table('agent_umrahs AS a')
            ->leftjoin('users', 'a.created_by','users.id')
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
            ->where(['a.draft'=>1,'a.status'=>0])
            ->whereBetween(DB::raw('DATE(a.created_at)'),Account::financial_year())
            ->when($request->agentID, function($query)use($request){
                $agentID=DB::table('agents')->where('id',$request->agentID)->value('UID');
                $query->where('created_by', $agentID);
            })
            ->groupBy('pnr')
            ->paginate(50);
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
