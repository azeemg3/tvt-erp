<?php

namespace App\Http\Controllers\Providors;

use App\Http\Controllers\Controller;
use App\Models\Accounts\ServiceProvidor;
use App\Models\Accounts\TransactionAccount;
use App\Models\VisaAgentPrice;
use App\Models\VisaRate;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Helpers\Account;

class VisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
            $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
            return VisaRate::with('source')
                ->where('source',$source_id)
                ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
                ->when($request->visa_type, function ($query) use ($request){
                    $query->where('visa_type', $request->visa_type);
                })->orderByDesc('id')->paginate(15);
        }else {
            return view('providors.visa.index');
        }
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
            'visa_type'=>'required',
        ];
        $message=[
            'visa_type.required'=>'Visa Type Required',
        ];
        $this->validate($request,$rules,$message);
//        $data=$request->except(['_token','']);
        $adult=json_encode($request->adult);
        $child=json_encode($request->child);
        $infant=json_encode($request->infant);
        $id=$request->id;
        $data['visa_type']=$request->visa_type;
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        $data['source']=$source_id;
        $data['validity_from']=$request->validity_from;
        $data['validity_to']=$request->validity_to;
        $data['adult_det']=$adult;
        $data['child_det']=$child;
        $data['infant_det']=$infant;
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=VisaRate::create($data);
                $agentData['agents']=0;
                $agentData['markup_type']=0;
                $agentData['markup_value']=0;
                $agentData['VRID']=$ret->id;
                VisaAgentPrice::create($agentData);
            }else{
                VisaAgentPrice::where("VRID", $id)->delete();
                VisaRate::where('id',$id)->update($data);
                for($i=0; $i<$count; $i++){
                    $agentData['agents']=$request['agents'][$i];
                    $agentData['markup_type']=$request['markup_type'][$i];
                    $agentData['markup_value']=$request['markup_value'][$i];
                    $agentData['VRID']=$id;
                    VisaAgentPrice::create($agentData);
                }
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
