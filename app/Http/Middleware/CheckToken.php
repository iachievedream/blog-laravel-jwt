<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckToken
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
            $user = JWTAuth::parseToken()->authenticate();//獲取令牌的方法
        } catch (Exception $e) {
        // } catch (TokenInvalidException $e) {
            // dd($e);
            //令牌無效異常
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException ){
                // dd($e);  
                return response()->json([
                    'success' => false,
                    'message' => 'Token is Invalid',
                    'data' => '',
                ]);
            //令牌過期異常
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token is Expired',
                    'data' => '',
                ]);
            } else {//其他如找不到授權令牌
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Authorization Token not found',
                    'data' => '',
                ]);
            }
        }
        return $next($request);
    }
}
