<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facede\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->get('password')),
            'role' =>'user',
        ]);

        $token = auth()->login($user);//得到token的方法,$user會員資訊內容

        return response()->json([
            'success' => true,
            'message' => '註冊成功',
            'data' => $token,
        ]);
    }

    public function login(Request $request)
    {
    	$credentials = $request->only(['email','password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'],401);//未認證
        }
    	return $this->respondWithToken($token);
    }

    public function logout()
    {
    	auth()->logout();
    	return response()->json(['message' => 'Successfully logged out']);
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