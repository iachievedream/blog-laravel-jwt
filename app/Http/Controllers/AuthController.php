<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facede\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($credentials->fails()) {
            return response()->json([
                'success' => false,
                'message' => '註冊不合格式',
                'data' => '',
            ]);
        } else {
            $credentials = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->get('password')),
                'role' =>'user',
            ]);

            $token = auth()->login($credentials);//得到token的方法,$user會員資訊內容

            return response()->json([
                'success' => true,
                'message' => '註冊成功',
                'data' => $token,
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
            $credentials = $request->only(['email','password']);
            if (! $token = auth()->attempt($credentials)) {
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

    public function refresh()
    {
    	return $this->respondWithToken(auth()->refresh());
    }

    public function respondWithToken($token)
    {
    	return response()->json([
    		'access_token' => $token,
    		'token_type' => 'bearer',
    		'expies_in' => auth()->factory()->getTTL()*60
    	]);
    }
}