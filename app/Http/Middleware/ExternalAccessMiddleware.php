<?php

namespace App\Http\Middleware;

use Closure;

class ExternalAccessMiddleware
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
        $keys = [
            'rims' => 9000
        ];

        if($request->hasHeader('token')){

            if($request->header('token') == $keys['rims']){
                return $next($request);
            }else{
                return response()->json(['data' => 'Permission Denied. Invalid Token', 'status' => 'fail'], 200);
            }

        }else{
            return response()->json(['data' => 'Permission Denied. Expected Token.', 'status' => 'fail'], 200);
        }

    }
}
