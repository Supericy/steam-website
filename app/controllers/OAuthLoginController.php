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

	private $userRepository;
	private $oauthAccountRepository;
	private $oauthProviderRepository;
	private $oauthManager;

	public function __construct(Icy\User\IUserRepository $userRepository, Icy\OAuth\IOAuthAccountRepository $oauthAccountRepository, Icy\OAuth\IOAuthProviderRepository $oauthProviderRepository, Icy\OAuth\IOAuthManager $oauthManager)
	{
		$this->userRepository = $userRepository;
		$this->oauthAccountRepository = $oauthAccountRepository;
		$this->oauthProviderRepository = $oauthProviderRepository;
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

		if (!Input::has('code'))
		{
			return Redirect::to($google->getAuthorizationUri()->getAbsoluteUri());
		}

		// assert(Input::has('code'))
		$code = Input::get('code');

		try
		{
			// This was a callback request from google, get the token
			$token = $google->requestAccessToken($code);

			// Send a request with it
			$result = json_decode($google->request('https://www.googleapis.com/oauth2/v1/userinfo' ));
		}
		catch (\OAuth\Common\Http\Exception\TokenResponseException $e)
		{
			Log::warning("User's token/code has probably expired", $e->getTrace());
			App::abort(400, 'Your token/code has probably expired, please try again.');
		}

		$googleAccountId = $result->id;
		$googleEmail = $result->email;
		$googleVerifiedEmail = $result->verified_email;
		$needsVerification = !$googleVerifiedEmail;

		$credentials = [
			'accountId' => $result->id,
			'email' => $result->email,
			'activated' => $googleVerifiedEmail,
			'isEmailVerified' => $result->verified_email,
		];

		if ($needsVerification)
		{
			// TODO: if their email hasn't been verified with the provider, we'll send them an e-mail to verify it. Set the account to NOT ACTIVE until they verify it

			// users email has not been verified
			FlashHelper::append('alerts.danger', sprintf('Your e-mail address (%s) has not been verified with Google, please verify it with them before attempting to login.', $googleEmail));
			return Redirect::action('get.login');
		}


		if (!$this->oauthManager->attemptLogin($providerName, $googleAccountId, true))
		{
			$loginMethods = $this->oauthManager->getLoginMethodsByEmail($credentials['email']);

			Debugbar::info(['loginMethods' => $loginMethods]);

			if (!empty($loginMethods))
			{
				return $this->redirectDisplayLoginMethods($loginMethods, $credentials);
			}
			else
			{
				assert('$googleVerifiedEmail == true', 'google email must be verified before we can create an account with it');

				$userRecord = $this->userRepository->firstOrCreate([
					'email' => $googleEmail,
					'password' => null,

					// we can guarentee $googleVerifiedEmail is true at this point
					'activated' => $googleVerifiedEmail
				]);

				// user does not have any way to log in, so let's create an account/loginMethod for them
				$this->oauthManager->createOAuthAccount($userRecord, $providerName, $googleAccountId);

				Auth::login($userRecord, true);
			}
		}

		return $this->loginSucessful();
	}

	private function redirectDisplayLoginMethods(array $loginMethods, array $credentials)
	{
		// prompt the user to login with an existing account/method
		FlashHelper::append('alerts.danger', sprintf('Your email (%s) is already in use. Please login to merge accounts.', $credentials['email']));

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

	private function loginSucessful()
	{
		FlashHelper::append('alerts.success', 'You have been logged in.');
		return Redirect::intended('/');
	}
	
}