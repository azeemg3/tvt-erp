<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Employee;
use App\Models\User;
use App\Models\Accounts\TransactionAccount;
use DB;
use Arr;
use Hash;
use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::pluck('name')->all();
        return view('Hr.employees.index', compact(['roles']));
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
            'first_name'=>'required',
            'last_name'=>'required',
            'cnic'=>'required',
            'work_email'=>'required',
            'private_email'=>'required',
            'mobile_phone'=>'required',
            'CID'=>'required',
            'CTID'=>'required',
            'address'=>'required',
        ];
        $message=[
            'first_name.required'=>'First Name Required',
            'last_name.required'=>'Last Name Required',
            'last_name.required'=>'Last Name Required',
            'cnic.required'=>'CNIC Required',
            'work_email.required'=>'Work Email Required',
            'private_email.required'=>'Private Email Required',
            'mobile_phone.required'=>'Mobile Required',
            'CID.required'=>'Country Required',
            'CTID.required'=>'City Required',
            'address.required'=>'Address Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'password', 'roles']);
        $id=$request->id;
        $uData['name']=$request->first_name.' '.$request->last_name;
        $uData['email']=$request->work_email;
        if(!empty($request->password)){
            $uData['password'] = Hash::make($request->password);
        }else{
            $uData = Arr::except($uData,array('password'));
        }
        //create account
        $tData['Trans_Acc_Name']=$request->first_name.' '.$request->last_name;
        $tData['PID']=6;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $user = User::create($uData);
                $user->assignRole($request->input('roles'));
                $data['UID']=$user->id;
                $data['created_by']=Auth::user()->id;
                $ret = Employee::create($data);
                $tData['Parent_Type']=$ret->id;
                $tData['created_by']=Auth::user()->id;
                TransactionAccount::create($tData);
            } else {
                $UID=Employee::find($id)->value('UID');
                $user = User::find($UID);
                $user->update($uData);
                DB::table('model_has_roles')->where('model_id',$UID)->delete();
                $user->assignRole($request->input('roles'));
                $ret = Employee::where('id', $id)->update($data);
                $tData['updated_by']=Auth::user()->id;
                TransactionAccount::where(['PID'=>6, 'Parent_Type'=>$id])->update($tData);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->getMessage(),
            ], 400);
            DB::rollback();
        }

    }
    //@listing employee data
    public function get_data(){
        return Employee::with('designation')->orderBy('id','DESC')->paginate(15);
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
        return Employee::find($id);
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
