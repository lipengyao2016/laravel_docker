<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/7/9
 * Time: 18:08
 */
namespace App\Common;

use Illuminate\Support\Facades\Date;

class UrlUtils
{

    public static function combineURL($baseURL,$keysArr){
        $combined = $baseURL."?";
        $valueArr = array();

        foreach($keysArr as $key => $val){
            $valueArr[] = "$key=$val";
        }

        $keyStr = implode("&",$valueArr);
        $combined .= ($keyStr);

        return $combined;
    }



}