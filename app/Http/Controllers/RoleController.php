<?php

namespace App\Http\Controllers;

use App\Models\RBAC\Role;
use Illuminate\Http\Request;
use App\Models\RBAC\Permission;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        if ( Cache::has('rolesWithPermissions') )
            $roles = Cache::get('rolesWithPermissions');
        else {
            $roles = Role::with('permissions')->get();
            Cache::put('rolesWithPermissions', $roles, 60*24);
        }
        return view('admin/role/index', compact('permissions', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin/role/create', compact('permissions'));
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
            'name'          => 'required|string|max:255|unique:roles',
            'permissions.*' => 'integer|distinct|exists:permissions,id',
        ]);
        $role = new Role($request->all());
        $role->save();

        $role->permissions()->attach($request->permissions);

        $role->clearRbacCache();

        return redirect()->route('roles.index')->with('message', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RBAC\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RBAC\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->permissions;
        return view('admin/role/edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RBAC\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $v = $this->validate($request, [
            'name'          => 'required|string|max:255|unique:roles,name,'.$role->id,
            'permissions.*' => 'integer|distinct|exists:permissions,id',
        ]);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);
        $role->clearRbacCache();
        return redirect()->route('roles.index')->with('message', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RBAC\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->permissions()->detach(); // detach permissions
        $role->admins()->detach(); // detach admins
        $role->delete();
        $role->clearRbacCache();
        return redirect()->route('roles.index')->with('message', '删除成功');
    }
}
