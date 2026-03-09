<?php

namespace App\Http\Controllers;

use App\Models\Accounts\Agent;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Province;

class StatisticsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:statistics_view', ['only' => ['index','admin_statistic','subadmin_statistic','agent_statistic']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $province=Province::all();
        return view('statistics.index', compact('province'));
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
    //admin statitic
    public function admin_statistic(){
        $provinces=Province::where('CID',166)->get();
        $cities=City::whereIn('PID', $provinces->pluck('id'))->get();
        $subAdmin=Agent::where('agent_type',0)
            ->whereIn('agent_city', $cities->pluck('id'))->get();
        return view('statistics.admin.index',
            compact('provinces','cities'));
    }
    public function subadmin_statistic(){
        return view('statistics.subadmin.index');
    }
    public function agent_statistic(){
        return view('statistics.agent.index');
    }
}
