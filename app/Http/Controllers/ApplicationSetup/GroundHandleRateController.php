<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\GroundHandleAgentPrice;
use Illuminate\Http\Request;
use App\Models\GroundHandleRate;
use DB;

class GroundHandleRateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ground_handle_rate_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Rate_setup.ground_handles.index');
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
            'comp_name'=>'required',
            'contact_details'=>'required',
        ];
        $message=[
            'comp_name.required'=>'Company Name Required',
            'contact_details.required'=>'Contact Details Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['_token']);
        $id=$request->id;
        //assign to agent
//        $request['agents'];
//        $assignAgent=explode('-', $request['agents']);
//        $count=count($request->markup_type);
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=GroundHandleRate::create($data);
//                for($i=0; $i<$count; $i++){
//                    $agentData['agents']=$assignAgent[$i];
//                    $agentData['markup_type']=$request['markup_type'][$i];
//                    $agentData['markup_value']=$request['markup_value'][$i];
//                    $agentData['GHID']=$ret->id;
//                    GroundHandleAgentPrice::create($agentData);
//                }
            }else{
                GroundHandleRate::where('id',$id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }catch (QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
        }
    }
    //@display data in list
    public function get_data(){
        return GroundHandleRate::
            whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
        ->paginate(15);
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
        return GroundHandleRate::find($id);
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
        return GroundHandleRate::destroy($id);
    }
}
