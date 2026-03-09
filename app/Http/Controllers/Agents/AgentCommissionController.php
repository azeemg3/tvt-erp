<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent\AgentCommission;
use Illuminate\Http\Request;
use DB;
use Auth;

class AgentCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.agent_commission.index');
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
            'product'=>'required',
            'validity'=>'required',
            'agents'=>'required',
        ];
        $message=[
            'product.required'=>'Product Required',
            'validity.required'=>'Validity Required',
            'agents.required'=>'Agents Required',
        ];
        $this->validate($request,$rules,$message);
        $data=request()->except(['_token','validity','agents']);
        $validity=explode('/',$request->validity);
        $data['validity_from']=$validity[0];
        $data['validity_to']=$validity[1];
        $id=$request->id;
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $data['created_by']=Auth::user()->id;
                foreach ($request->agents as $agent){
                    $data['SAID']=$agent;
                    AgentCommission::create($data);
                }

            }else{
                $data['SAID']=$request['agents'][0];
                AgentCommission::where('id',$id)->update($data);
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
    //dispay data in list
    public function get_data(){
        $result=AgentCommission::with(['agent','currency'])->paginate(15);
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
        return AgentCommission::find($id);
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
