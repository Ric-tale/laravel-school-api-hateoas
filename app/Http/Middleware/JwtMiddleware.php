<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Token is Invalid',
                    'data'    => null
                ], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Token is Expired',
                    'data'    => null
                ], 401);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Authorization Token not found',
                    'data'    => null
                ], 401);
            }
        }
        
        return $next($request);
    }
}
