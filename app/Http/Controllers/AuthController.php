<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facede\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
    	// $this->middleware('auth:api',['except' => ['login']]);
    }
    public function login()
    {
    	$credentials = request(['email','password']);

    	if (! $token = auth()->attempt($credentials)) {
        // if (! $token = auth()->claims(['nam'=>'fue'])->attempt($credentials)) {
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
    public function test()
    {
        
    }
}