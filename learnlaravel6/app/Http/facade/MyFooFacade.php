<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/7/31
 * Time: 18:39
 */

namespace App\Http\facade;


use Illuminate\Support\Facades\Facade;

class MyFooFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        //这里返回的是ServiceProvider中注册时,定义的字符串
        return 'myfoo';
    }
}