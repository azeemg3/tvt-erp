<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Null_;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role_view|role_create|role_edit|role_delete', ['only' => ['index','store']]);
        $this->middleware('permission:role_create', ['only' => ['create','store']]);
        $this->middleware('permission:role_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(100000);
        return view('Roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Roles.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
        return view('Roles.show',compact('role','rolePermissions'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $result=Permission::where(['parent_id'=>0])->orWhere('parent_id',Null)->get();
        $htmlData='';
        foreach ($result as $item) {
            $htmlData .= '<tr>';
            $htmlData .= '<td></td>';
            $htmlData .= '<td>'.$item->name.'</td>';
            $permission=Permission::where('parent_id', $item->id)->get();
            foreach ($permission as $per) {
                $htmlData .= '<td><input '.((in_array($per->id, $rolePermissions))?'checked':'').' type="checkbox" name="permission[]" value="'.$per->id.'"> </td>';
            }
            if($item->form==0){
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
            }
        }
        return view('Roles.edit',compact('role','permission','rolePermissions','htmlData'));
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }
    //@sotre all of the menu which are ass with permissons
    public function store_menu(Request $request){
        $rules = [
            'name' => 'required',
        ];
        $message=[
            'name.required'=>'Menu Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        if($id=='' || $id==0){
            $ret=Menu::create($data);
        }else{
            $ret=Menu::where('id', $id)->update($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    //@get menu data
    public function get_menu(){
        $result=Permission::where(['parent_id'=>0])->orWhere('parent_id',NULL)->get();
        $htmlData='';
        foreach ($result as $item) {
            $htmlData .= '<tr>';
            $htmlData .= '<td></td>';
            $htmlData .= '<td>'.$item->name.'</td>';
            $permission=Permission::where('parent_id', $item->id)->get();
            foreach ($permission as $per) {
                $htmlData .= '<td><input type="checkbox" name="permission[]" value="'.$per->id.'"> </td>';
            }
            if($item->form==0){
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
                $htmlData .= '<td><input type="checkbox" name="permission[]" disabled value=""> </td>';
            }
        }
        return compact('htmlData');
    }

}