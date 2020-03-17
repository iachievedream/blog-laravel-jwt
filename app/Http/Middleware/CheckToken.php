<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        // dd($request->headers);//token確認
        // // dd($request->headers->authorization);//token抓不到
        // // dd($request->headers('authorization'));//token抓不到
        // if ($request->headers->authorization){
        // }
        try{
            $user = JWTAuth::parseToken()->authenticate();//獲取Token方法
            // dd($request);
            // dd($user);
        // } catch (Exception $e) {
        } catch (TokenExpiredException $e) {//refresh 更換後跳進這個迴圈，但錯誤未抓到
            // dd($e);
            // if (is_null($user)) {
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Token ',
                //     'data' => '',
                // ]);                
            // }
            $token = JWTAuth::getToken();
            $newToken = JWTAuth::refresh($token);
            // $newToken = JWTAuth::refresh(true, true);//將舊的列入黑名單
            //dd($token,$newToken);
            $request->headers->set('Authorization', 'Bearer'.$newToken);
            // dd($request, $newToken);
            return response()->json([
                'success' => false,
                'message' => 'Token 已過期，請更換新的Token',
                'data' => $newToken,
            ]);
        } catch (TokenInvalidException $e){
                return response()->json([
                    'success' => false,
                    'message' => 'Token 無效',
                    'data' => '',
            ]);
        } catch (TokenBlacklistedException  $e){
            // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 列入黑名單',
                    'data' => '',
            ]);
        } catch (Exception $e){
                // dd($e);
                return response()->json([
                    'success' => false,
                    'message' => 'Token 有其他錯誤',
                    'data' => '',
            ]);
        }
        return $next($request);
    }
}
