<?php

namespace App\Http\Controllers\Reports\Umrah;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CheckoutReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Reports.Umrah.checkout.index');
    }
    /*
    * fetch data report while call ajax
    */
    public function get_data(Request $request){
        $res=DB::table('agent_umrah_hotel_details AS h')
            ->leftjoin('cities','h.city','cities.id')
            ->join('hotels','h.hotel_id','hotels.id')
            ->join('room_types','h.room_type','room_types.id')
            ->leftjoin('agent_umrahs AS a','h.UID','a.id')
            ->leftjoin('group_details AS g','a.group_no','g.id')
            ->select('h.*', 'cities.name As city_name','hotels.name as hotel_name',
                DB::raw('(SELECT  px.pax_name FROM agent_umrah_pax_details AS px
                 WHERE h.UID=px.UID LIMIT 1) AS pax_name'),
                DB::raw('(SELECT  count(id) FROM agent_umrah_pax_details AS px
                 WHERE h.UID=px.UID LIMIT 1) AS total_pax'),'room_types.name AS rt',
                'g.group_code')
            ->where('a.status',1)
            ->whereBetween(DB::raw('DATE(a.created_at)'),Account::financial_year())
            ->when($request->df, function ($query) use ($request) {
                $query->whereBetween(DB::raw('DATE(h.checkout)'),
                    [$request->df, $request->dt]);
            })->orderBy('h.UID','DESC')
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
