<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Spatie\Permission\Models\Permission;
use DB;
class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ticket_source_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.index');
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
        $rules = [
            'name' => 'required',
        ];
        $message=[
            'name.required'=>'Menu Name Required',
        ];
        $this->validate($request, $rules, $message);
        $fixstr=str_replace(' ', '_', strtolower($request->name));
        $data=request()->except(['_token']);
        $id=$request->id;
        if($id=='' || $id==0){
            $ret=Permission::create($data);
            Permission::create(['name'=>$fixstr.'_view', 'parent_id'=>$ret->id]);
            if($request->form==1){
                Permission::create(['name'=>$fixstr.'_create','parent_id'=>$ret->id]);
                Permission::create(['name'=>$fixstr.'_edit','parent_id'=>$ret->id]);
                Permission::create(['name'=>$fixstr.'_delete','parent_id'=>$ret->id]);
                Permission::create(['name'=>$fixstr.'_approve','parent_id'=>$ret->id]);
                Permission::create(['name'=>$fixstr.'_send','parent_id'=>$ret->id]);
                Permission::create(['name'=>$fixstr.'_upload', 'parent_id'=>$ret->id]);
            }

        }else{
            Permission::where('parent_id', $id)->delete();
            $ret=Permission::where('id', $id)->update($data);
            Permission::create(['name'=>$fixstr.'_view', 'parent_id'=>$id]);
            if($request->form==1){
                Permission::create(['name'=>$fixstr.'_create','parent_id'=>$id]);
                Permission::create(['name'=>$fixstr.'_edit','parent_id'=>$id]);
                Permission::create(['name'=>$fixstr.'_delete','parent_id'=>$id]);
                Permission::create(['name'=>$fixstr.'_approve','parent_id'=>$id]);
                Permission::create(['name'=>$fixstr.'_send','parent_id'=>$id]);
                Permission::create(['name'=>$fixstr.'_upload', 'parent_id'=>$id]);
            }
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    //@dipsay data in listing
    public function get_data(){
        return Permission::where(['parent_id'=>0])->orWhere('parent_id', Null)->orderBy('id', 'DESC')->paginate(15);
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
        return Permission::find($id);
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
        Permission::destroy($id);
    }

    public function get_role_permission($id){
        return Permission::where('parent_id', $id)->get();
    }
}
