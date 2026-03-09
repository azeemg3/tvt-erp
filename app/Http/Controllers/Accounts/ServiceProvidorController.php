<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\ServiceProvidor;
use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Accounts\TransactionAccount;

class ServiceProvidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.service_providors.index');
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
            'name'=>'required',
            'email'=>'required',
        ];
        $message=[
            'name.required'=>'Name Required',
            'email.required'=>'Mobile Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','product_includes','password']);
        $id=$request->id;
        //create account
        if($request->agent_type==0) {
            $products=implode(',',$request->product_includes);
            $data['product_includes'] = $products;
        }
        $tData['Trans_Acc_Name']=$request->name;
        $tData['PID']=9;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=ServiceProvidor::create($data);
                $uData['name']=$request->name;
                $uData['email']=$request->email;
                $uData['password'] = Hash::make($request->password);
                $user = User::create($uData);
                $user->assignRole('Providor');
                $tData['Parent_Type']=$ret->id;
                $tData['code']='SP-'.$ret->id;
                TransactionAccount::create($tData);
                ServiceProvidor::where('id', $ret->id)->update(['UID'=>$user->id]);
            } else {
                $sp=ServiceProvidor::find($id);
                ServiceProvidor::where('id', $id)->update($data);
                $uData['name']=$request->name;
                $uData['email']=$request->email;
                $uData['password'] = Hash::make($request->password);
                User::where('id', $uData)->update($uData);
                $user=User::find($sp->UID);
                DB::table('model_has_roles')->where('model_id',$sp->UID)->delete();
                $user->assignRole('Providor');
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
     * dispalay data in list
     */
    public function get_data(){
        $result=ServiceProvidor::paginate(50);
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
        return ServiceProvidor::find($id);
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
