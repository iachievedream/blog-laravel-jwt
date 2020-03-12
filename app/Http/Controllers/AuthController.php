<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facede\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
// use JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // public function __construct()
    // {
    // }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->get('password')),
            'role' =>'user',
        ]);
      $token = auth()->login($user);//得到token的方法

      return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
    	$credentials = $request->only(['email','password']);
        // dd($credentials);
        if (! $token = auth()->attempt($credentials)) {//JWTAuth::attempt
         return response()->json(['error' => 'Unauthorized'],401);
        }
    	return $this->respondWithToken($token);
    }

    public function me()
    {
    	return response()->json(auth()->user());
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

    public function payload()
    {
        return auth()->payload();

    }
}