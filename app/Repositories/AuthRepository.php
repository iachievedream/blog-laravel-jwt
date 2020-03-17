<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
	public function getRegister(array $data)
	{
		$register = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
        ]);
		// dd($register);
		// dd(gettype($register));//物件
        return $register;
	}
	
	public function getLogin(array $data)
	{
		$token = auth()->attempt($data);
		// dd($token);
		// dd(gettype($token));//字串
		return $token;
	}
}