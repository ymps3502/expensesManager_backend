<?php

namespace App\Http\Middleware;

use Closure;

class PreflightResponse
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
        // $headers = [
        //     'Access-Control-Allow-Origin' => '*',
        //     'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        //     'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin, Authorization'
        // ];
    
        // if($request->isMethod("OPTIONS")) {
        //     return $next($request)
        //         ->header('Access-Control-Allow-Origin', '*')
        //         ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE');
        // } 
        return $next($request);
    }
}
