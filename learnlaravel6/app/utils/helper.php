<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/8/8
 * Time: 19:04
 */

function decodeUnicode($str)
{
    return preg_replace_callback("#\\\u([0-9a-f]+)#i",function($m){return iconv('UCS-2','UTF-8', pack('H4', $m[1]));},$str);
}

/**
 * curl 请求
 * @param $url
 * @param $data
 * @return bool|string
 */
function curl($url, $params = false, $ispost = 0, $https = 0)
{
    $headers = array(
        "Content-type:application/json;charset=utf-8"
    );
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // https
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    }
    // 发起post请求
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params); // 此处就是参数的列表,给你加了个?
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);


    $errorNo = curl_errno($ch);
    if ($errorNo)
    {
        Log::debug(__METHOD__.' errorNo:'.$errorNo);
        throw new Exception(curl_error($ch),0);
    }
    else
    {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        Log::debug(__METHOD__.' httpStatusCode:'.$httpStatusCode);
        Log::debug(__METHOD__.' $response:'.$response);

        if (200 !== $httpStatusCode && 201 != $httpStatusCode)
        {
            throw new Exception($httpStatusCode);
        }
    }

//    if ($response === FALSE) {
//        //echo "cURL Error: " . curl_error($ch);
//        return false;
//    }
    // 详细信息
    //  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //  $httpInfo = array_merge($httpInfo, curl_getinfo($ch));

    // Log::debug(__METHOD__.' httpCode:'.$httpCode);
    //Log::debug(__METHOD__.' httpInfo:'.json_encode($httpInfo));

    curl_close($ch);
    return $response;
}