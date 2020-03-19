<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
	protected $authRepository;

	public function __construct(AuthRepository $authRepository)
	{
		$this->authRepository = $authRepository;
	}

	public function registers(array $data)
	{
		return $this->authRepository->getRegister($data);
	}

	public function logins(array $data)
	{
		return $this->authRepository->getLogin($data);
	}

}