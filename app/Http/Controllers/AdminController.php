<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RBAC\Role;
use App\Events\CreateAvatar;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(20);
        return view('admin/admin/index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin/admin/create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证
        $this->validate($request, [
            'name'          => 'required|string|max:255|unique:admins',
            'email'         => 'required|string|email|max:255|unique:admins',
            'password'      => 'required|min:6|max:60',
            'roles.*'       => 'integer|distinct|exists:roles,id',
            'avatarL'       => 'nullable|image_base64|max:100000', // base64 的大小约为图片的 4/3，大约允许 100kb 的上传文件
            'avatarM'       => 'nullable|image_base64|max:750000',
            'avatarS'       => 'nullable|image_base64|max:500000',
        ]);

        // 创建用户
        $admin = new Admin($request->all());
        $admin->password = bcrypt($request->password);
        $admin->save();

        // 如果有上传头像，则设置头像
        // 5.5 中 request->has 只检查是否有键，即便值是 false
        // filled 需要有键同时值不为空
        if ( $request->filled('avatarL') && $request->filled('avatarM') && $request->filled('avatarS') ) {
            $avatarPath = event(new CreateAvatar($admin));
            $admin->avatar = $avatarPath[0]; // listener 返回会套上一个数组
        }
        $admin->save();

        // attach roles
        $admin->roles()->attach($request->roles);

        // 根据新用户 id 确定生成头像路径
        return json($admin, 201);
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
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin/admin/edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $this->validate($request, [
            'name'          => 'required|string|max:255|unique:admins,name,'.$admin->id,
            'email'         => 'required|string|email|max:255|unique:admins,email,'.$admin->id,
            'password'      => 'nullable|min:6|max:60',
            'roles.*'       => 'integer|distinct|exists:roles,id',
            'avatarL'       => 'nullable|image_base64|max:100000',
            'avatarM'       => 'nullable|image_base64|max:750000',
            'avatarS'       => 'nullable|image_base64|max:500000',
        ]);

        // 是否更新密码
        if ( $request->filled('password') )
            $request->merge(['password' => bcrypt($request->password)]);
        else
            $request->offsetUnset('password');

        $admin->fill($request->input());

        if ( $request->filled('avatarL') && $request->filled('avatarM') && $request->filled('avatarS') ) {
            $avatarPath = event(new CreateAvatar($admin)); // 即使有旧头像也会覆盖掉

            // 用户之前用的是默认头像，需要设置成新的。有设置头像的话，则不变，因为路径不会变的
            if ( $avatarPath[0] != $admin->avatar ) {
                $admin->avatar = $avatarPath[0];
            }
        }
        $admin->save();

        $admin->roles()->sync($request->roles); // 更新关联数据

        return json( $admin, 201 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        // 软删除，保留关联数据，只有在删除 role 的时候 detach admin

        return redirect()->route('admins.index')->with('message', '删除成功');
    }

    public function profile()
    {
        $admin = \Auth::user();
        return view('admin/admin/profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = \Auth::user();
        $this->validate($request, [
            'name'          => 'required|string|max:255|unique:admins,name,'.$admin->id,
            'email'         => 'required|string|email|max:255|unique:admins,email,'.$admin->id,
            'password'      => 'nullable|min:6|max:60',
            'avatarL'       => 'nullable|image_base64|max:100000',
            'avatarM'       => 'nullable|image_base64|max:750000',
            'avatarS'       => 'nullable|image_base64|max:500000',
        ]);

        // 是否更新密码
        if ( $request->filled('password') )
            $request->merge(['password' => bcrypt($request->password)]);
        else
            $request->offsetUnset('password');

        $admin->fill($request->input());

        if ( $request->filled('avatarL') && $request->filled('avatarM') && $request->filled('avatarS') ) {
            $avatarPath = event(new CreateAvatar($admin)); // 即使有旧头像也会覆盖掉

            // 用户之前用的是默认头像，需要设置成新的。有设置头像的话，则不变，因为路径不会变的
            if ( $avatarPath[0] != $admin->avatar ) {
                $admin->avatar = $avatarPath[0];
            }
        }
        $admin->save();

        return json( $admin, 201 );
    }
}
