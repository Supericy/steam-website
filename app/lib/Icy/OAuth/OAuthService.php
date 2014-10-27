<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/23/2014
 * Time: 11:20 PM
 */
namespace Icy\OAuth;


class OAuthService implements IOAuthService {

	public static $LOGIN_METHODS = [
		'Default',
		'Google',
	];

	private $auth;
	private $user;
	private $oauthAccount;
	private $oauthProvider;

	public function __construct(\Illuminate\Auth\AuthManager $auth, \Icy\User\IUserRepository $user, IOAuthAccountRepository $oauthAccount, IOAuthProviderRepository $oauthProvider)
	{
		$this->auth = $auth;
		$this->user = $user;
		$this->oauthAccount = $oauthAccount;
		$this->oauthProvider = $oauthProvider;
	}

	public function attemptLogin($providerName, $accountId, $remember = true)
	{
		if ($userRecord = $this->user->getByProviderNameAndAccountId($providerName, $accountId))
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
		$email = $this->user->normalize(['email' => $email])['email'];

		$loginMethods = [];

		if ($userRecord = $this->user->getByEmail($email))
		{
			$loginMethods = $this->getLoginMethods($userRecord);
		}

		return $loginMethods;
	}

	public function createOAuthAccount($userId, $providerName, $accountId)
	{
		$oauthProviderRecord = $this->oauthProvider->getByName($providerName);

		$oauthAccountRecord = $this->oauthAccount->create([
			'user_id' => $userId,
			'provider_id' => $oauthProviderRecord->id,
			'account_id' => $accountId
		]);

		return $oauthAccountRecord;
	}

}