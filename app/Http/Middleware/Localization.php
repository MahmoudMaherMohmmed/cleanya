<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check header request and determine localizaton
        $local = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : 'ar';
        
        // set laravel localization
        app()->setLocale($local);

        return $next($request);
    }
}
