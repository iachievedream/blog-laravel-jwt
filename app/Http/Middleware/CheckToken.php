<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckToken extends BaseMiddleware
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
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                // dd($e);

                //待了解
                // $token = $this->auth->refresh;
                $token = JWTAuth::getToken();
                $token = JWTAuth::refresh($token);

                return response()->json([
                    'success' => false,
                    'message' => 'Token 過期',
                    'data' => $token,
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
