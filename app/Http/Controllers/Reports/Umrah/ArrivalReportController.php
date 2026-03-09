<?php

namespace App\Http\Controllers\Reports\Umrah;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ArrivalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Reports.Umrah.arrival.index');
    }
    /*
     * displsay data in list
     */
    public function get_data(Request $request){
        $res=DB::table('agent_umrahs as au')
            ->leftjoin('group_details as g','au.group_no','g.id')
            ->leftjoin('cities as city','au.arr_terminal','city.id')
            ->select(DB::raw('IFNULL(g.group_code,"N/A") AS group_code'),
                DB::raw('(SELECT px.pax_name FROM agent_umrah_pax_details AS px
                 WHERE px.UID=au.id and px.group_leader=1 LIMIT 1) AS pax_name'),'au.arr_flight',
                DB::raw('DATE_FORMAT(arr_date,"%d-%m-%Y") AS arrival_date'),
                DB::raw('arr_time AS arr_time'),'au.arr_sector',
                DB::raw('(SELECT  count(id) FROM agent_umrah_pax_details AS px
                 WHERE px.UID=au.id LIMIT 1) AS total_pax'),
                DB::raw('(select hotel_id from agent_umrah_hotel_details as h where h.UID=au.id LIMIT 1) AS hotel_id'),
                DB::raw('(select name from hotels where id=hotel_id LIMIT 1) AS hotel_name'),
                DB::raw('(select transport_type from agent_umrah_transport_details as tr where tr.UID=au.id LIMIT 1) AS transport'),
                DB::raw('(select CONCAT(DATE_FORMAT(transport_date,"%d-%m-%y")," ",transport_time) from agent_umrah_transport_details as tr where tr.UID=au.id LIMIT 1) AS transport_time')
                ,'city.name AS city_name')
            ->where(['au.status'=>1])
            ->whereBetween(DB::raw('DATE(au.created_at)'),Account::financial_year())
            ->when($request->df, function ($query) use ($request){
                $query->whereBetween('au.arr_date',[$request->df,$request->dt]);
            })
            ->paginate(50);
        return $res;
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
