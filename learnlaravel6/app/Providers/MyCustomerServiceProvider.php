<?php

namespace App\Providers;

use App\Http\module\MyFoo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use SMartins\PassportMultiauth\Http\Middleware\MultiAuthenticate;

class MyCustomerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

       Log::debug(__METHOD__.' called.');
        //也可以这么绑定
        $this->app->bind("myfoo", function(){
            return new MyFoo();
        });

/*        $this->app->bind("multiauth", function(){
            return new MultiAuthenticate();
        });*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       // Log::debug(__METHOD__.' called.');
    }
}
