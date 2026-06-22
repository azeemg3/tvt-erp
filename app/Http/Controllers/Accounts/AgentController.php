<?php

namespace App\Http\Controllers\Accounts;

use App\Helpers\AccountCodeHelper;
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
        $id = $request->id;
        $isNew = ($id == '' || $id == 0);

        $rules = [
            'agent_name' => 'required',
            'agent_mobile' => 'required',
            'agent_email' => 'required|email',
            'agent_code' => 'required',
        ];
        if ($isNew) {
            $rules['password'] = 'required|min:6';
        }
        if ($request->agent_type == 1) {
            $rules['agentID'] = 'required';
        }
        $message = [
            'agent_name.required' => 'Agent Name Required',
            'agent_mobile.required' => 'Agent Mobile Required',
            'agent_email.required' => 'Agent Email Required',
            'agent_code.required' => 'Agent Code Required',
            'password.required' => 'Password Required',
            'password.min' => 'Password must be at least 6 characters',
            'agentID.required' => 'Please assign this subagent to a parent agent',
        ];
        $this->validate($request, $rules, $message);

        $data = $request->except(['_token', 'assign_products', 'password']);
        if ($request->agent_type == 0 && $request->has('assign_products')) {
            $data['assign_products'] = implode(',', $request->assign_products);
        }
        $tData = [
            'Trans_Acc_Name' => $request->agent_name,
            'PID' => 21,
        ];
        $tData['code'] = AccountCodeHelper::nextTransactionCode(21);

        DB::beginTransaction();
        try {
            if ($isNew) {
                $data['created_by'] = Auth::user()->id;
                $ret = Agent::create($data);
                $uData = [
                    'name' => $request->agent_name,
                    'email' => $request->agent_email,
                    'is_agent' => 2,
                    'password' => Hash::make($request->password),
                ];
                $user = User::create($uData);
                $user->assignRole('Agent');
                $tData['Parent_Type'] = $ret->id;
                TransactionAccount::create($tData);
                Agent::where('id', $ret->id)->update(['UID' => $user->id]);
            } else {
                $agent = Agent::find($id);
                Agent::where('id', $id)->update($data);
                $uData = [
                    'name' => $request->agent_name,
                    'email' => $request->agent_email,
                    'is_agent' => 2,
                ];
                if (!empty($request->password)) {
                    $uData['password'] = Hash::make($request->password);
                }
                if ($agent->UID == 0 || $agent->UID == '') {
                    if (empty($request->password)) {
                        DB::rollBack();
                        return response()->json([
                            'errors' => ['password' => ['Password is required to create login for this agent']],
                        ], 422);
                    }
                    $uData['password'] = Hash::make($request->password);
                    $user = User::create($uData);
                    $user->assignRole('Agent');
                    $tData['Parent_Type'] = $agent->id;
                    TransactionAccount::create($tData);
                    Agent::where('id', $id)->update(['UID' => $user->id]);
                } else {
                    User::where('id', $agent->UID)->update($uData);
                    $user = User::find($agent->UID);
                    DB::table('model_has_roles')->where('model_id', $agent->UID)->delete();
                    $user->assignRole('Agent');
                }
            }
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => 'false',
                'errors' => ['error' => $e->getMessage()],
            ], 400);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => 'false',
                'errors' => ['error' => $e->getMessage()],
            ], 400);
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
