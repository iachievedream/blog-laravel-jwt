<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
//\Tymon\JWTAuth\Exceptions\TokenExpiredException
//instanceofg3m/4使用use

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
            //過期，無效，可以另外用，順序問題，
            //過期(refresh在header與例外),無效
            //不用if eles(不能抓例外)
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $newToken = auth()->refresh(true, true);//將舊的列入黑名單
                //request帶Token找這麼帶，直接替換，可以印出
                return response()->json([
                    'success' => false,
                    'message' => 'Token 已過期，請更換新的Token',
                    'data' => $newToken,
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException  ){
                // dd($e);
                //黑名單如會員登出後的token狀況，以及refresh後的狀況。
                return response()->json([
                    'success' => false,
                    'message' => 'Token 列入黑名單',
                    'data' => '',
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 無效',
                    'data' => '',
                ]);
            } else {
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 有其他錯誤',
                    'data' => '',
                ]);
            }
        }
        return $next($request);
    }
}
