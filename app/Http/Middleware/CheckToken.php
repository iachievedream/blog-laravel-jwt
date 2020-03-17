<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

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
            dd($e);
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // dd($e);

                // //待了解(JWTAuth不同的套件，所以產生無法捕捉的錯誤嗎?)
                // $token = JWTAuth::getToken();//得到現有Token
                // $newToken = JWTAuth::refresh($token);//更新現有Token

                //官網資訊(測試好像不如預測的狀況)
                // $newToken = auth()->refresh();//未將舊的列入黑名單
                $newToken = auth()->refresh(true, true);//將舊的列入黑名單

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
