<?php namespace Icy;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/16/2014
 * Time: 1:53 AM
 */

class UserManager {

	/**
	 * @var User\IUserRepository
	 */
	private $userRepository;
	/**
	 * @var User\ActivationManager
	 */
	private $activationManager;

	public function __construct(User\IUserRepository $userRepository, User\ActivationManager $activationManager)
	{
		$this->userRepository = $userRepository;
		$this->activationManager = $activationManager;
	}

	public function createAccount($credentials)
	{
		$needsActivation = $credentials['active'];

		$userRecord = $this->userRepository->create($credentials);

		if ($needsActivation)
		{

		}
	}

} 