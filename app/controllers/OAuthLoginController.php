<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/20/2014
 * Time: 6:19 PM
 */ 

class OAuthLoginController extends Controller {

	const METHOD_PREFIX = 'loginWith';

	// TODO: load from OAuthManager
	private $providers = [
		'google' => 'Google'
	];

	private $user;
	private $oauthAccount;
	private $oauthProvider;
	private $oauthManager;

	public function __construct(Icy\User\IUserRepository $user, Icy\OAuth\IOAuthAccountRepository $oauthAccount, Icy\OAuth\IOAuthProviderRepository $oauthProvider, Icy\OAuth\IOAuthManager $oauthManager)
	{
		$this->user = $user;
		$this->oauthAccount = $oauthAccount;
		$this->oauthProvider = $oauthProvider;
		$this->oauthManager = $oauthManager;
	}

	public function login($providerName)
	{
		if (($methodName = $this->generateMethodName($providerName)) !== false)
		{
			return $this->{$methodName}();
		}
		else
		{
			App::abort(404, sprintf('OAuth provider (%s) is not supported.', $providerName));
		}
	}

	private function generateMethodName($providerName)
	{
		if (!array_key_exists($providerName, $this->providers))
			return false;

		return self::METHOD_PREFIX . $this->providers[$providerName];
	}

	private function loginWithGoogle()
	{
		$providerName = 'Google';

		// redirect through url shortener since we can't pass localhost URL
//		$google = OAuth::consumer($providerName, 'http://snurl.com/299s1vu'); // homestead.app:8000/login/oauth/google
		$google = OAuth::consumer($providerName, 'http://snurl.com/29ammpu'); // homestead.app/login/oauth/google

		if (Input::has('code'))
		{
			$code = Input::get('code');

			// redirected back from google
			// store code, get user email

			try
			{
				// This was a callback request from google, get the token
				$token = $google->requestAccessToken($code);

				// Send a request with it
				$result = json_decode( $google->request('https://www.googleapis.com/oauth2/v1/userinfo' ), true);
			}
			catch (\OAuth\Common\Http\Exception\TokenResponseException $e)
			{
//				return Redirect::to($google->getAuthorizationUri()->getAbsoluteUri());
				dd($e->getMessage() . "\nCode has probably expired, try again");
			}

			$googleAccountId = $result['id'];
			$googleEmail = $result['email'];
			$googleVerifiedEmail = $result['verified_email'];
			$needsVerification = !$googleVerifiedEmail;

			$credentials = [
				'accountId' => $result['id'],
				'email' => $result['email'],
				'active' => $googleVerifiedEmail,
				'isEmailVerified' => $result['verified_email'],
			];

			if ($needsVerification)
			{
				// TODO: if their email hasn't been verified with the provider, we'll send them an e-mail to verify it. Set the account to NOT ACTIVE until they verify it

				// users email has not been verified
				FlashHelper::append('alerts.danger', sprintf('Your e-mail address (%s) has not been verified with Google, please verify your email.', $googleEmail));
				return Redirect::action('get.login');
			}


			if ($this->oauthManager->attemptLogin($providerName, $googleAccountId, true))
			{
				return $this->loginSucessful();
			}
			else
			{
				$loginMethods = $this->oauthManager->getLoginMethodsByEmail($credentials['email']);

				Debugbar::info(['loginMethods' => $loginMethods]);

				if (!empty($loginMethods))
				{
					// prompt the user to login with an existing account/method
					FlashHelper::append('alerts.danger', sprintf('Your email (%s) is already in use. Please login to merge accounts.', $googleEmail));

					$loginMethodsToDisplay = [];

					foreach (Icy\OAuth\OAuthManager::$LOGIN_METHODS as $loginMethod)
					{
						$loginMethodsToDisplay[$loginMethod] = in_array($loginMethod, $loginMethods);
					}

					// TODO: fix displaying only available login methods

					Debugbar::info(['loginMethodsToDisplay' => $loginMethodsToDisplay]);

					return Redirect::action('get.login')
						->with('displayLoginMethod', $loginMethodsToDisplay);
				}
				else
				{
					assert('$googleVerifiedEmail == true', 'google email must be verified before we can create an account with it');

					$userRecord = $this->user->firstOrCreate([
						'email' => $googleEmail,
						'password' => null,

						// we can guarentee $googleVerifiedEmail is true at this point
						'active' => $googleVerifiedEmail
					]);

					// user does not have any way to log in, so let's create an account/loginMethod for them
					$this->oauthManager->createOAuthAccount($userRecord, $providerName, $googleAccountId);
					Auth::login($userRecord, true);

					return $this->loginSucessful();
				}
			}

		}
		else
		{
			return Redirect::to($google->getAuthorizationUri()->getAbsoluteUri());
		}
	}

	private function loginSucessful()
	{
		FlashHelper::append('alerts.success', 'You have been logged in.');
		return Redirect::intended('/');
	}
	
}