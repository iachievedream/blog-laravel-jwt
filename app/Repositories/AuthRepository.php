<?php

namespace App\Repositories;

// use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
	public function getRegisters(array $data)
	{
		$createUser = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
        ]);
        return $createUser;
	}
	
	public function getLogins(array $data)
	{
		// $email = $data['email'];
		// $password = $data['password'];
		// $getLogins = array('email'=>$email,'password'=>$password);

		$getLogin = array(
			'email'=>$data['email'],
			'password'=>$data['password']
		);
		$token = auth()->attempt($getLogin);
		return $token;
	}
}