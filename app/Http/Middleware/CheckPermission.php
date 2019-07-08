<?php

namespace App\Http\Middleware;

use Cache;

use Closure;
use App\Models\Admin;
use App\Models\RBAC\Permission;

class CheckPermission
{
    /**
     * 根据请求 方法+地址 来确定访问的用户是否有权限继续操作
     *
     * 生产环境，会把权限-角色的映射关系缓存起来，在验证过程中只查询当前访问用户的角色。
     *
     * 注意本中间件只判断权限，调用时配合 auth:admin 先检查登录状态
     * 如：'middleware' => ['auth:admin', 'checkPermission'],
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestAction = $request->route()->methods[0]; // request methods: GET / POST / PUT / DELETE
        $requestUri = $request->route()->uri; // request uri：api/v0/admin/permissions/{permission}

        // 当前管理员的相关角色
        $adminRoles = Admin::find($request->user()->id)->roles;

        // 排序为1的是 root 不用检查权限
        foreach ( $adminRoles as $role ) {
            if( $role->sort == 1 ) return $next($request);
        }

        // 获取缓存
        if ( Cache::has('uriWithRoles') )
            $uriWithRoles = Cache::get('uriWithRoles');
        else {
            // fetch all permissions with roles
            $permissions = Permission::all()->load('roles');

            // forech permissions, return an array like [ action,uri => [ roleId, ... ] ]
            foreach ( $permissions as $permission ) {
                $key = $permission->action . ',' . $permission->uri;
                $uriWithRoles[$key] = [];
                foreach ( $permission->roles as $role ) {
                    $uriWithRoles[$key][] = $role->id;
                }
            }

            if (! config('app.debug'))
                Cache::put('uriWithRoles', $uriWithRoles, 60*24); // 24h
        }
        // 当前访问地址没有设置访问权限，使用时避免这样用了权限中间件又没设置的情况
        if ( ! isset($uriWithRoles[$requestAction.','.$requestUri]) )
            return $next($request);

        // 判断当前用户的角色是否在 $uriWithRoles 的当前链接里
        foreach ( $adminRoles as $adminRole ) {
            if ( in_array($adminRole->id, $uriWithRoles[$requestAction.','.$requestUri]) )
                return $next($request);
        }

        // 判断返回 json 或跳转到其他页面
        $tmp = explode('/', $requestUri);
        if ( $tmp[0] == 'api' )
            return response()->json(['message'=>'You do not have permission to access this page'], 403);
        else {
            // 避免重定向循环错误
            if (session()->previousUrl() == $request->url())
                return redirect()->route('dashboard')->withErrors('You do not have permission to access this page');
            else
                return back()->withErrors('You do not have permission to access this page');
        }

    }

}
