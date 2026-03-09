<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\SubHeadAccount;
use Illuminate\Http\Request;
use DB;

class SubHeadAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Accounts.subhead_accounts.index');
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
            'HID'=>'required',
            'name' => 'required|unique:sub_head_accounts,name',
        ];
        $message=[
            'HID.required'=>'Head Account Required',
            'name.required'=>'Subhead Account Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token', 'password', 'roles']);
        $data['editable']=1;
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                SubHeadAccount::create($data);
            } else {
                SubHeadAccount::where('id', $id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //@listing data
    public function get_data(Request $request){
        return DB::table('sub_head_accounts')->join('head_accounts', 'sub_head_accounts.HID','head_accounts.id')
            ->join('root_accounts','head_accounts.RID','root_accounts.id')
            ->select('sub_head_accounts.*','head_accounts.name AS head_name', 'root_accounts.name AS root_name')
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
