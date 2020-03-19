<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

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
        try{
            $user = JWTAuth::parseToken()->authenticate();//取得會員的認證資料
        } catch (TokenExpiredException $e) {
            // dd($e);
            try{
                $token = JWTAuth::getToken();
                $newToken = JWTAuth::refresh($token);
                var_dump($newToken);//新toker
                $user = auth()->setToken($newToken)->user();
                $request->headers->set('Authorization', 'Bearer' . $user);
            } catch (TokenBlacklistedException $e) {
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 為黑名單',
                    'data' => '',
                ],401);                
            }
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token 無效(含數字錯誤或是登出狀況)',
                'data' => '',
            ],401);
        } catch (JWTException $e) {
            // dd($e);
            return response()->json([
                'success' => false,
                'message' => 'Token 無法解析(Token未填)',
                'data' => '',
            ],400);
        }
        return $next($request);
    }
}
