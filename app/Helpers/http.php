<?php

/**
 * HTTP 相关
 */

/**
 * 获取状态码对应的信息字符串
 */
if ( ! function_exists('getHttpMessage') )
{
    function getHttpMessage(int $code)
    {
        switch($code)
        {
            case 200:
                return '请求成功';
            case 201:
                return '创建或修改成功';
            case 202:
                return '接受请求';
            case 204:
                return '删除成功'; // 204 实际上并不会返回任何东西

            case 400:
                return '错误的请求';
            case 401:
                return '认证失败';
            case 403:
                return '没有权限执行该操作';
            case 404:
                return '资源没有找到';
            case 406:
                return 'Not Acceptable';
            case 410:
                return '请求的资源已删除';
            case 422:
                return '参数非法';

            case 500:
                return '服务器发生错误';

            default:
                return 'code ' . $code;
        }
    }
}

if ( ! function_exists('json') )
{
    function json($resource = null, int $code = 200)
    {
        $arr = [
            'message'       => 'success',
            'success'       => getHttpMessage($code),
            'data'          => $resource,
        ];

        if (config('app.debug')) {
            $arr['debug']['total_query']    = count( \DB::getQueryLog() );
            $arr['debug']['sql']            = \DB::getQueryLog();
            $arr['debug']['time']           = round( microtime(true) - LARAVEL_START, 3) . ' s';
        }

        return response()->json( $arr, $code );
    }
}
