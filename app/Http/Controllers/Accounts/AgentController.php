<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use App\Models\Accounts\Agent;
use DB;
use Auth;
use Hash;
use App\Models\User;
class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.subagent.index');
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
            'agent_name'=>'required',
            'agent_mobile'=>'required',
            'agent_email'=>'required',
        ];
        $message=[
            'agent_name.required'=>'Agent Name Required',
            'agent_mobile.required'=>'Agent Mobile Required',
            'agent_email.required'=>'Agent Email Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','assign_products']);
        $id=$request->id;
        //create account
        if($request->agent_type==0) {
            $products=implode(',',$request->assign_products);
            $data['assign_products'] = $products;
        }
        $tData['Trans_Acc_Name']=$request->agent_name;
        $tData['PID']=21;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=Agent::create($data);
                $uData['name']=$request->agent_name;
                $uData['email']=$request->agent_email;
                $uData['is_agent'] =2;
                $uData['password'] = Hash::make($request->password);
                $user = User::create($uData);
                $user->assignRole('Agent');
                $tData['Parent_Type']=$ret->id;
                TransactionAccount::create($tData);
                Agent::where('id', $ret->id)->update(['UID'=>$user->id]);
            } else {
                $agent=Agent::find($id);
                Agent::where('id', $id)->update($data);
                $uData['name']=$request->agent_name;
                $uData['email']=$request->agent_email;
                $uData['is_agent'] =2;
                $uData['password'] = Hash::make('123456');
                if($agent->UID==0 || $agent->UID==''){
                    $user = User::create($uData);
                    $user->assignRole('Agent');
                    $tData['Parent_Type']=$agent->id;
                    TransactionAccount::create($tData);
                    Agent::where('id', $id)->update(['UID'=>$user->id]);
                }else {
                    User::where('id', $uData)->update($uData);
                    $user=User::find($agent->UID);
                    DB::table('model_has_roles')->where('model_id',$agent->UID)->delete();
                    $user->assignRole('Agent');
                }
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollBack();
        }
        return response()->json(['success' => 'Added new record Successfully.']);
    }
    //@agent list
    public function get_data(Request $request){
        return Agent::with('subagent')->where('agent_type',1)->paginate(15);
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
        return Agent::find($id);
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
