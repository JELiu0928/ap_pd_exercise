<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class JwtMiddleware
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
        try{
            JWTAuth::parseToken()->authenticate();
        }catch(Exception $e)
        {
            return response()->json([
                'error'=>'401 Unauthorized',
                'msg'=>$e->getMessage(),
            ],401);
        }

        return $next($request);
    }
}
