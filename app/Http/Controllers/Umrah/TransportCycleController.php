<?php

namespace App\Http\Controllers\Umrah;

use App\Http\Controllers\Controller;
use App\Models\Umrah\TransportCycle;
use App\Models\UmrahTransportCity;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Helpers\Account;
class TransportCycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('umrah.transport_cycle.index');
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
            'route.*'=>'required',
        ];
        $message=[
            'route.required'=>'Route Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','from_city','to_city']);
        $id=$request->id;
        $sectorDet='';
        $count=count($request->from_city);
        for($i=0; $i<$count; $i++){
            $sectorDet.=UmrahTransportCity::find($request['from_city'][$i])->name;
            $sectorDet.="•";
            $sectorDet.=UmrahTransportCity::find($request['to_city'][$i])->name;
            $sectorDet.="•";
        }
        $data['route']=rtrim($sectorDet,"•");
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=TransportCycle::create($data);
                DB::commit();
                return $ret;
            } else {
                DB::commit();
                return TransportCycle::where('id', $id)->update($data);

            }

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //display data in list
    public function get_data(Request $request){
        $result=TransportCycle::whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())->paginate(50);
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
        return TransportCycle::find($id);
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
