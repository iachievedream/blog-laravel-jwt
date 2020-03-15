<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $register = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($register->fails()) {
            return response()->json([
                'success' => false,
                'message' => '註冊不合格式',
                'data' => '',
            ]);
        } else {
            $this->authService->registers($request->all());
            return response()->json([
                'success' => true,
                'message' => '註冊成功',
                'data' => '',
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => '登入不合格式',
                'data' => '',
            ]);
        } else {
            $token = $this->authService->logins($request->all());

            // $credentials = request(['email', 'password']);
            // $credentials = $request->only(['email','password']);
            // dd(gettype($credentials));

            if (! $token) {
                return response()->json([
                    'success' => false,
                    'message' => '未經授權',
                    'data' => '',
                ]);
            } else {
                return $this->respondWithToken($token);
            }
        }
    }

    public function logout()
    {
    	auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
            'data' => '',
        ]);
    }

    // public function refresh()
    // {
    // 	return $this->respondWithToken(auth()->refresh());
    // }

    public function respondWithToken($token)
    {
    	return response()->json([
    		'access_token' => $token,
    		'token_type' => 'bearer',
    		'expies_in' => auth()->factory()->getTTL()*60
    	]);
    }
}