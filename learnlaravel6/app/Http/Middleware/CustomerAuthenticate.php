<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CustomerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug(__METHOD__.' start:');
        $authMiddleObj = app('auth');
        $multiAuthMiddleObj = app('multiauth');
        Log::debug(__METHOD__.' authMiddleObj:'.$authMiddleObj);
        Log::debug(__METHOD__.' multiAuthMiddleObj:'.$multiAuthMiddleObj);

        $authObjs = [
            $authMiddleObj,$multiAuthMiddleObj
        ];


     /*   try{
            $authMiddleObj->handl
        }
        catch (\Exception $e)
        {

        }*/



        return $next($request);
    }
}
