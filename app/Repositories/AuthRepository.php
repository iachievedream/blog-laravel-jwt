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
		// $email = $data['email'];
		// $password = $data['password'];
		// $getLogins = array('email'=>$email,'password'=>$password);

		$login = array(
			'email'=>$data['email'],
			'password'=>$data['password']
		);
		$token = auth()->attempt($login);
		return $token;
	}
}