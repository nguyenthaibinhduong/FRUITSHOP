<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $role;
    private $permission;
    public function __construct(Role $role,Permission $permission){
        $this->role=$role;
        $this->permission=$permission;
    }
    public function index()
    {
        $roles = $this->role->all();
        return view('admin.role.index',compact('roles'));
    }
    public function create()
    {
        $permissions = $this->permission->all()->groupBy('group');
        return view('admin.role.create', compact('permissions'));

    }
    public function store(Request $request)
    {
       
        $roleCreate=$this->role->create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'group'=>$request->group
        ]);
        $roleCreate->permissions()->attach($request->permissions);
        return redirect()->route('role');
    }
    public function edit($id)
    {
        $role = $this->role->find($id);
        $permissions = $this->permission->all()->groupBy('group');
        $getAllPermissionOfRole = DB::table('permission_role')->where('role_id',$id)->pluck('permission_id');
        return view('admin.role.edit',compact('role','permissions','getAllPermissionOfRole'));
    }
    public function update($id,Request $request)
    {
        $role=$this->role->find($id);
        $role->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'group'=>$request->group
        ]);
        $role->permissions()->detach();
        $role->permissions()->attach($request->permissions);
        return redirect()->route('role');
    }
    public function delete($id)
    {   $role=$this->role->find($id);
        $role->delete();
        $role->permissions()->detach();
        return redirect()->route('role');
    }
}