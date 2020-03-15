<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
// use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

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
            $user = JWTAuth::parseToken()->authenticate();//獲取Token方法
        } catch (Exception $e) {
        // } catch (TokenBlacklistedException $e) {
            // dd($e);
            //Token列入黑名單(如登出等狀況)
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException  ){
                // dd($e);  
                return response()->json([
                    'success' => false,
                    'message' => 'Token 列入黑名單',
                    'data' => '',
                ]);
            //Token無效(定義有些廣泛，所以順序在前面會被解取錯誤訊息，而小錯誤就無法發現了)
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 無效',
                    'data' => '',
                ]);
            //Token過期
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 過期',
                    'data' => '',
                ]);
            } else {//其他如找不到Token
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 未輸入',
                    'data' => '',
                ]);
            }
        }
        return $next($request);
    }
}
