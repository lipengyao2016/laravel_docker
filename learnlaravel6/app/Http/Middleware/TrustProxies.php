<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Support\Facades\Log;

//define('START_TIME', microtime(true));

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    public function handle(Request $request, Closure $next)
    {
        $startTime =  microtime(true);
        Log::debug("*************************TrustProxies Middleware begin ->handle url:" . $request->fullUrl()
            .' method:'.$request->method());
        Log::debug($request);

        $ret =  parent::handle($request,$next);

        Log::debug("*************************TrustProxies Middleware end ->handle url:" . $request->fullUrl()
            .' method:'.$request->method().' tm:'.(microtime(true)-$startTime)*1000 );
        return $ret;
    }
}
