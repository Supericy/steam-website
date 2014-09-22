<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/20/2014
 * Time: 6:19 PM
 */ 

class OAuthLoginController extends Controller {

	private $providers = [
		'google' => 'Google'
	];

	private $user;
	private $oauthAccount;
	private $oauthProvider;

	public function __construct(Icy\User\UserRepository $user, Icy\OAuth\IOAuthAccountRepository $oauthAccount, Icy\OAuth\IOAuthProviderRepository $oauthProvider)
	{
		$this->user = $user;
		$this->oauthAccount = $oauthAccount;
		$this->oauthProvider = $oauthProvider;
	}

	public function login($provider)
	{
		if (array_key_exists($provider, $this->providers))
		{
			return $this->{'loginWith' . $this->providers[$provider]}();
		}
		else
		{
			App::abort(404, 'OAuth provider not found.');
		}
	}

	private function loginWithGoogle()
	{
		$providerName = 'Google';

		// redirect through url shortener since we can't pass localhost URL
		$google = OAuth::consumer($providerName, 'http://snurl.com/299s1vu');

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

			if (!$googleVerifiedEmail)
			{
				// TODO: if their email hasn't been verified with the provider, we'll send them an e-mail to verify it. Set the account to NOT ACTIVE until they verify it

				// users email has not been verified
				FlashHelper::append('alerts.danger', sprintf('Your e-mail address (%s) has not been verified with Google, please verify your email.', $googleEmail));
				return Redirect::action('get.login');
			}


			// TODO: refactor most of this logic out of controller
			// attempt to get the user by provider user id
			if ($userRecord = $this->user->getByProviderAndAccountId($providerName, $googleAccountId))
			{
				Auth::login($userRecord);

				FlashHelper::append('alerts.success', 'You have been logged in.');

				return Redirect::intended('/');
			}
			// test if the email address is already in the database
			else if ($userRecord = $this->user->getByEmail($googleEmail))
			{
				// their google email is already taken, start merging process

				// TODO: implement merging process, for now, we'll just error
				FlashHelper::append('alerts.danger', sprintf('Your e-mail address (%s) is already taken, please use a different one', $googleEmail));
				return Redirect::action('get.register');
			}
			else
			{
				// ok, let's create them an account
				$userRecord = $this->user->create([
					'email' => $googleEmail,
					'password' => null,

					// no need to active here, as long as the service providers email as been verified
					'active' => true
				]);

				$oauthProviderRecord = $this->oauthProvider->getByName($providerName);

				$oauthAccountRecord = $this->oauthAccount->create([
					'user_id' => $userRecord->id,
					'provider_id' => $oauthProviderRecord->id,
					'account_id' => $googleAccountId
				]);

				Auth::login($userRecord);

				FlashHelper::append('alerts.success', 'You have been logged in.');

				return Redirect::intended('/');
			}
		}
		else
		{
			return Redirect::to($google->getAuthorizationUri()->getAbsoluteUri());
		}
	}
	
}