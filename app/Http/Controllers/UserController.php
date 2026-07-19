<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ModuleManager;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user_list_view', ['only' => ['index']]);
        $this->middleware('permission:user_list_create', ['only' => ['create','store']]);
        $this->middleware('permission:user_list_edit', ['only' => ['edit']]);
        $this->middleware('permission:user_list_delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('users.index');
    }
    public function get_data(Request $request)
    {
        $data = User::with('roles')
            ->where('is_agent', 0)
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('roles', function ($row) {
                $roles = $row->getRoleNames();
                if ($roles->isEmpty()) {
                    return '<span class="text-muted">N/A</span>';
                }

                $html = '';
                foreach ($roles as $role) {
                    $html .= '<label class="badge badge-success mr-1">' . e($role) . '</label>';
                }
                return $html;
            })
            ->addColumn('user_status', function ($row) {
                return $row->status == 0 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('users.show', $row->id);
                $editUrl = route('users.edit', $row->id);
                $deleteUrl = route('users.destroy', $row->id);
                $token = csrf_token();

                return '<a class="btn btn-xs btn-info" href="' . $showUrl . '"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-xs btn-primary" href="' . $editUrl . '"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="' . $deleteUrl . '" style="display:inline">
                            <input type="hidden" name="_token" value="' . $token . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                        </form>';
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name')->all();
        $modules = ModuleManager::all();
        return view('users.create',compact('roles','modules'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required|not_in:0',
            'modules' => 'nullable|array',
            'modules.*' => 'in:'.implode(',', $this->modulePermissionNames()),
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $this->syncModulePermissions($user, (array) $request->input('modules', []));
        return back()->with('success','User created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $modules = ModuleManager::all();
        $userModules = $user->getDirectPermissions()
            ->pluck('name')
            ->intersect($this->modulePermissionNames())
            ->values()
            ->all();
        return view('users.edit',compact('user','roles','userRole','modules','userModules'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required|not_in:0',
            'modules' => 'nullable|array',
            'modules.*' => 'in:'.implode(',', $this->modulePermissionNames()),
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        $this->syncModulePermissions($user, (array) $request->input('modules', []));
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

    /**
     * Permission names of all registered business modules (config/modules.php).
     *
     * @return string[]
     */
    private function modulePermissionNames(): array
    {
        return collect(ModuleManager::all())
            ->pluck('permission')
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Sync the user's DIRECT module permissions with the checked modules.
     * Checked modules are granted, unchecked ones are revoked; any other
     * direct permissions the user may have are left untouched.
     */
    private function syncModulePermissions(User $user, array $selected): void
    {
        foreach ($this->modulePermissionNames() as $permissionName) {
            // Ensure the permission exists so grants never fail silently.
            Permission::findOrCreate($permissionName, 'web');

            if (in_array($permissionName, $selected, true)) {
                $user->givePermissionTo($permissionName);
            } else {
                $user->revokePermissionTo($permissionName);
            }
        }

        $user->forgetCachedPermissions();
    }
}