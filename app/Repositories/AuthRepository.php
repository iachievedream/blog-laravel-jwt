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
        return $register;
	}
	
	public function getLogin(array $data)
	{
		$token = auth()->attempt($data);
		return $token;
	}
}