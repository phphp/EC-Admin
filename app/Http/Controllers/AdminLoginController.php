<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        // 登录时，通过验证跳转的地址
        // 中间件认证的用户跳转地址这项没用。需要在 RedirectIfAuthenticated 中间件设置
        $this->redirectTo = route('dashboard');
    }

    /**
     * 登录页面
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * 重写 AuthenticatesUsers guard()，选择 admin guard
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * 登出，跳转到管理员登录页面
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect(route('admin.login.page'));
    }
}
