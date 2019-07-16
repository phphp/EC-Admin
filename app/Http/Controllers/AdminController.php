<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
        return view('admin/admin/create');
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
            // 'roles.*'       => 'integer|distinct|exists:roles,id',
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
        if ( $request->filled('avatarL') && $request->filled('avatarM') && $request->filled('avatarS') )
            $admin->avatar = Avatar::saveAvatar($admin->id, 'uploads/avatars/admin');
        $admin->save();

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
        return view('admin/admin/edit', compact('admin'));
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
            // 'roles.*'       => 'integer|distinct|exists:roles,id',
            'avatarL'       => 'nullable|image_base64|max:100000',
            'avatarM'       => 'nullable|image_base64|max:750000',
            'avatarS'       => 'nullable|image_base64|max:500000',
        ]);
        // $admin = Admin::findOrFail($id);
        // $this->bcryptInputPassword($request);

        // 是否更新密码
        if ( $request->filled('password') )
            $request->merge(['password' => bcrypt($request->password)]);
        else
            $request->offsetUnset('password');

        $admin->fill($request->input());

        if ( $request->filled('avatarL') && $request->filled('avatarM') && $request->filled('avatarS') )
            $admin->avatar = Avatar::saveAvatar($admin->id, 'uploads/avatars/admin');

        $admin->save();

        // $admin->roles()->sync($request->roles); // 更新关联数据

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
        // 删除头像事件
        return redirect()->route('admins.index')->with('message', '删除成功');
    }

    /**
     * 加密表单中的 password 字段，password 为空，则从 $request 中剔除它
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request 剔除或加密 password 后的 $request
     */
    private function bcryptInputPassword($request)
    {
        if ( $request->filled('password') )
            $request->merge(['password' => bcrypt($request->password)]);
        else
            $request->offsetUnset('password');

        return $request;
    }
}
