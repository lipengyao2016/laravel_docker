<?php
/**
 * Created by PhpStorm.
 * User: user_1234
 * Date: 2019/8/13
 * Time: 18:30
 */

namespace App\Listeners;


use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event) {
        Log::debug(__METHOD__.' user:'.json_encode($event->user).
        ' guard:'.$event->guard);
    }

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event) {
        Log::debug(__METHOD__.' user:'.json_encode($event->user).
            ' guard:'.$event->guard);
    }

    /**
     * 为订阅者注册监听器
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }

}