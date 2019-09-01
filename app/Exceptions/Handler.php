<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * 重写 AuthenticationException unauthenticated()
     * 路径： vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php
     * 认证失败时根据不同的 guard 执行不同的操作
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // 客户端需要响应 json
        if ( $request->expectsJson() )
            response()->json(['message' => $exception->getMessage()], 401);
        // 其他响应
        else
        {
            // AuthenticationException::guards() 获取 guard 名
            // 中间件 "auth", guards() == null
            // 中间件 "auth:admin", guards()[0] == admin
            if ( $exception->guards() == null )
                return redirect()->guest(route('login')); // 普通用户登录页
            else
            {
                // auth:admin 的中间件
                if ( $exception->guards()[0] == 'admin' )
                    return redirect()->guest(route('admin.login'));
                // elseif...

                // other guard
                return redirect()->guest(route('login'));
            }
        }
    }
}
