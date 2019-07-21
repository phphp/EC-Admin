<?php

/**
 * 关联性不大的工具类函数
 */

/**
 * cURL 函数，返回 false 或页面结果
 * 如果是 json
 */
if ( ! function_exists('curl') )
{
    /**
     * @param $url 请求网址
     * @param bool $params 请求参数
     * @param int $ispost 请求方式
     * @param int $https https协议
     * @return bool|mixed
     */
    function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

}


/**
 * 传递文件名，返回上传的临时文件的路径
 */
if ( ! function_exists('getTmpImagePath') )
{
    function getTmpImagePath($fileName)
    {
        return public_path('uploads/tmp/' . $fileName . '.jpg');
    }
}

/**
 * 把 ID 转成路径
 */
if ( ! function_exists('IDToDir') )
{
    /**
     * @param int $userID 用户 ID
     * @return str ID 转化为目录的路径，如 0/00/00/01
     */
    function IDToDir($userID)
    {
        $userID = sprintf("%07d", $userID);
        $rs = '';
        for ($i=0; $i < 3 ; $i++) {
            $dir = substr($userID,-2);
            $userID = substr($userID, 0, -2);
            $rs = $dir.'/' . $rs;
        }
        $dir = $userID . '/' . $rs;
        return rtrim($dir, '/');
    }
}
