<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RBAC\Permission;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin/permission/index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/permission/create');
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
            'name'      => 'required|string|max:255|unique:permissions',
            'action'    => ['required', 'string', Rule::in(['GET', 'POST', 'PUT', 'DELETE'])],
            'uri'       => 'required|string|max:255|unique:permissions',
        ]);

        $permission = new Permission($request->all());
        $permission->save();

        // 根据新用户 id 确定生成头像路径
        return redirect()->route('permissions.index')->with('message', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RBAC\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RBAC\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin/permission/edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RBAC\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name'      => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'action'    => ['required', 'string', Rule::in(['GET', 'POST', 'PUT', 'DELETE'])],
            'uri'       => 'required|string|max:255|unique:permissions,uri,' . $permission->id,
        ]);

        $permission->fill($request->input());
        $permission->save();
        return redirect()->route('permissions.index')->with('message', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RBAC\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        $permission->roles()->detach();
        return redirect()->route('permissions.index')->with('message', '删除成功');
    }
}
