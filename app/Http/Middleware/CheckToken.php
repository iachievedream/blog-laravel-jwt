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
        // $user = JWTAuth::parseToken()->authenticate()
        // dd($user);
        try {
            $user = JWTAuth::parseToken()->authenticate();//獲取令牌的方法
            // dd($user);
        } catch (Exception $e) {
            // dd($e);
            //令牌無效異常
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // dd($e);//異常TokenBlacklistedException  
                return response()->json(['status' => 'Token is Invalid']);
            //令牌過期異常
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // dd($e);
                return response()->json(['status' => 'Token is Expired']);
            //令牌黑名單異常(測試跑去TokenInvalidException)
            }else if ($e instanceof Tymon\JWTAuth\Exceptions\TokenBlacklistedException ){
                return response()->json(['status' => 'Token is Token Blacklisted Exception ']);
            }else{//其他如找不到授權令牌
                // dd($e);
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
