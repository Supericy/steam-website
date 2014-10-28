<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/23/2014
 * Time: 11:20 PM
 */
namespace Icy\OAuth;


use Icy\User\IUserRepository;
use Illuminate\Auth\AuthManager;

class OAuthService implements IOAuthService {

	public static $LOGIN_METHODS = [
		'Default',
		'Google',
	];

	private $auth;
	private $userRepository;
	private $oauthAccountRepository;
	private $oauthProviderRepository;

	public function __construct(AuthManager $auth, IUserRepository $userRepository, IOAuthAccountRepository $oauthAccountRepository, IOAuthProviderRepository $oauthProviderRepository)
	{
		$this->auth = $auth;
		$this->userRepository = $userRepository;
		$this->oauthAccountRepository = $oauthAccountRepository;
		$this->oauthProviderRepository = $oauthProviderRepository;
	}

	public function login($providerName, $accountId, $remember = true)
	{
		if ($userRecord = $this->userRepository->getByProviderNameAndAccountId($providerName, $accountId))
		{
			$this->auth->login($userRecord, $remember);

			return $userRecord;
		}

		// couldn't log in the user,
		return false;
	}

	public function getLoginMethods(\Icy\User\User $userRecord)
	{
		$providers = $userRecord->oauthProviders()->get();

		$loginMethods = [];

		if ($userRecord->hasPassword())
		{
			$loginMethods[] = 'Default';
		}

		foreach ($providers as $provider)
		{
			$loginMethods[] = $provider->name;
		}

		return $loginMethods;
	}

	public function getLoginMethodsByEmail($email)
	{
		$email = $this->userRepository->normalize(['email' => $email])['email'];

		$loginMethods = [];

		if ($userRecord = $this->userRepository->getByEmail($email))
		{
			$loginMethods = $this->getLoginMethods($userRecord);
		}

		return $loginMethods;
	}

	public function createOAuthAccount($userId, $providerName, $accountId)
	{
		$oauthProviderRecord = $this->oauthProviderRepository->getByName($providerName);

		$oauthAccountRecord = $this->oauthAccountRepository->create([
			'user_id' => $userId,
			'provider_id' => $oauthProviderRecord->id,
			'account_id' => $accountId
		]);

		return $oauthAccountRecord;
	}

}