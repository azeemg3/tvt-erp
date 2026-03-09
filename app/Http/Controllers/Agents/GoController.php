<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Accounts\Agent;
use Hash;
use App\Models\User;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Support\Arr;
class GoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.go.index');
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
            'mosqueID'=>'required',
        ];
        $message=[
            'agent_name.required'=>'Group Organiser Name Required',
            'agent_mobile.required'=>'GO Mobile Required',
            'agent_email.required'=>'Go Email Required',
            'mosqueID.required'=>'Mosque Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','assign_products','agent_code']);
        $id=$request->id;
        //create account
        if(isset($request->assign_products)) {
            $products = implode(',', $request->assign_products);
        }
        $data['assign_products'] = $products;
        $tData['Trans_Acc_Name']=$request->agent_name;
        $tData['PID']=21;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $data['agent_type']=2;
                $ret=Agent::create($data);
                $uData['name']=$request->agent_name;
                $uData['email']=$request->agent_email;
                $uData['is_agent'] =1;
                $uData['password'] = Hash::make($request->password);
                $user = User::create($uData);
                $user->assignRole('GO');
                $tData['Parent_Type']=$ret->id;
                TransactionAccount::create($tData);
                Agent::where('id', $ret->id)->update(['agent_code'=>'GO-'.$ret->id,'UID'=>$user->id]);
            } else {
                $agent=Agent::find($id);
                $data['agent_type']=2;
                Agent::where('id', $id)->update($data);
                $uData['name']=$request->agent_name;
                $uData['email']=$request->agent_email;
                $uData['is_agent'] =3;
                if(!empty($request->password)){
                    $uData['password'] = Hash::make($request->password);
                }
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
    /*
     * dispay data in list
     */
    public function get_data(){
        return Agent::where('agent_type',2)->paginate(15);
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
