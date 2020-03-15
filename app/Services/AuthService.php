<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
	protected $articleRepository;

	public function __construct(AuthRepository $authRepository)
	{
		$this->authRepository = $authRepository;
	}

	public function registers(array $data)
	{
		return $this->authRepository->getRegisters($data);
	}

	public function logins(array $data)
	{
		return $this->authRepository->getLogins($data);
	}

}