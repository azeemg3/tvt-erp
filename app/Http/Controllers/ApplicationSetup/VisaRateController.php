<?php

namespace App\Http\Controllers\ApplicationSetup;

use App\Http\Controllers\Controller;
use App\Models\Lms\Visa;
use Illuminate\Http\Request;
use App\Models\VisaRate;
use App\Models\VisaAgentPrice;
use DB;
use App\Models\Accounts\Agent;
use App\Helpers\Account;
class VisaRateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:visa_rate_view', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Rate_setup.visa_rate.index');
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
            'source'=>'required',
        ];
        $message=[
            'visa_type.required'=>'Visa Type Required',
            'source.required'=>'Visa Source Required',
        ];
        $this->validate($request,$rules,$message);
//        $data=$request->except(['_token','']);
        $adult=json_encode($request->adult);
        $child=json_encode($request->child);
        $infant=json_encode($request->infant);
        $id=$request->id;
        $data['visa_type']=$request->visa_type;
        $data['source']=$request->source;
        $data['currency_id']=$request->currency_id;
        $data['currency_rate']=$request->currency_rate;
        $data['validity_from']=$request->validity_from;
        $data['validity_to']=$request->validity_to;
        $data['adult_det']=$adult;
        $data['child_det']=$child;
        $data['infant_det']=$infant;
        //assign to agent
        $count=count($request->markup_type);
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $ret=VisaRate::create($data);
                for($i=0; $i<$count; $i++){
                    $agentData['agents']=$request['agents'][$i];
                    $agentData['markup_type']=$request['markup_type'][$i];
                    $agentData['markup_value']=$request['markup_value'][$i];
                    $agentData['VRID']=$ret->id;
                    VisaAgentPrice::create($agentData);
                }
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
    //@dispay data in list
    public function get_data(Request $request){
        return VisaRate::with('source')
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->when($request->visa_type, function ($query) use ($request){
                $query->where('visa_type', $request->visa_type);
            })->orderByDesc('id')->paginate(15);
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
        $res=VisaRate::find($id);
        $agents=VisaAgentPrice::where('VRID', $id)->get();
        $data='';
        $i=0;
        foreach ($agents as $agent){
            $data.='<div class="row"> 
                            <div class="form-group col-md-4">
                            <select class="form-control form-control-sm select2 agent" name="agents[]">
                            '.Agent::agent($agent->agents).'
                            </select>
                            </div>
                            <div class="form-group col-md-2">
                            <select class="form-control form-control-sm" name="markup_type[]">
                            <option value="1" '.(($agent->markup_type==1)?'selected':'').'>%</option>
                            <option value="2" '.(($agent->markup_type==2)?'selected':'').'>Fixed</option>
                            </select>
                            </div>
                            <div class="col-md-2">
                            <input type="text" name="markup_value[]" class="form-control form-control-sm" placeholder="Enter..."
                            value="'.$agent->markup_value.'">
                            </div>
                            <div class="form-group col-md-1">
                             '.(($i==0)?'
                            <button type="button" class="btn btn-xs btn-primary" onclick="more_item()">
                                        <i class="fa fa-plus"></i> </button>
                            </div>'
                    :'
                            <button type="button" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i> </button>
                            ').'
                            </div>';
            $i++;
        }
        return compact('res','data');
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
        return VisaRate::destroy($id);
    }
    public function approve_visa_rate($id){
        return VisaRate::where('id',$id)->update(['status'=>1]);
    }
}
