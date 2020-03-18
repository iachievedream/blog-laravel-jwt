<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
            $user = JWTAuth::parseToken()->authenticate();//取得會員資料
        } catch (TokenExpiredException $e) {
            // dd($e);
            try{
                $token = JWTAuth::getToken();
                $newToken = JWTAuth::refresh($token);
                var_dump($newToken);
                $user = auth()->setToken($newToken)->user();
                // var_dump($user);
                // dd($user);
                $request->headers->set('Authorization', 'Bearer'.$user);

            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token 錯誤',
                    'data' => '',
                ]);                
            }
        } catch (TokenInvalidException $e){
            return response()->json([
                'success' => false,
                'message' => 'Token 無效',
                'data' => '',
            ]);
        } catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Token 錯誤',
                'data' => '',
            ]);
        }
        return $next($request);
    }
}
