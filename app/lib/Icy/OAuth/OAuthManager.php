<?php 
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/23/2014
 * Time: 11:20 PM
 */
namespace Icy\OAuth;


class OAuthManager implements IOAuthManager {

	private $auth;
	private $user;
	private $oauthAccount;
	private $oauthProvider;

	public function __construct(\Illuminate\Auth\Guard $auth, \Icy\User\IUserRepository $user, IOAuthAccountRepository $oauthAccount, IOAuthProviderRepository $oauthProvider)
	{
		$this->auth = $auth;
		$this->user = $user;
		$this->oauthAccount = $oauthAccount;
		$this->oauthProvider = $oauthProvider;
	}

	public function attempt($providerName, array $credentials)
	{
		/*
		 * $creds = ['email', 'accountId', 'isEmailVerified']
		 */

		$credentials = $this->user->normalize($credentials);

		if ($userRecord = $this->user->getByProviderNameAndAccountId($providerName, $credentials['accountId']))
		{
			$this->auth->login($userRecord);

			return $userRecord;
		}
		else if ($userRecord = $this->user->getByEmail($credentials['email']))
		{
			// ok, so the oauth account doesn't exist, and we've detected a duplicate email,

			$providers = $userRecord->oauthProviders();
			$loginMethods = [];

			if ($userRecord->hasPassword())
			{
				$loginMethods[] = 'Default';
			}

			foreach ($providers as $provider)
			{
				$loginMethods[] = $provider->name;
			}

			throw new OAuthAccountMergeRequired($loginMethods);
		}
	}

//	public function merge(array $credentials)
//	{
//		$credentials = $this->user->normalize($credentials);
//
//		if ($this->auth->check())
//		{
//			if ($this->auth->user()->email === $credentials['email'])
//			{
//				// alright, the emails match, so lets create the OAuthAccount
//			}
//		}
//	}

//	public function createOAuthAccount(array $credentials)
//	{
//		$userRecord = $this->user->create([
//			'email' => $credentials['email'],
//			'password' => null,
//
//			// no need to active here, as long as the service providers email as been verified
//			'active' => true
//		]);
//
//		$oauthProviderRecord = $this->oauthProvider->getByName($providerName);
//
//		$oauthAccountRecord = $this->oauthAccount->create([
//			'user_id' => $userRecord->id,
//			'provider_id' => $oauthProviderRecord->id,
//			'account_id' => $googleAccountId
//		]);
//
//		Auth::login($userRecord);
//	}

} 