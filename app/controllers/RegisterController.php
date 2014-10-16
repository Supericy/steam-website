<?php

use \Illuminate\Support\Str;

class RegisterController extends Controller {

	/**
	 * @var \Icy\User\IUserManager
	 */
	private $userManager;

	public function __construct(Icy\User\IUserManager $userManager)
	{
		$this->userManager = $userManager;
	}

    public function getRegister()
    {
        return View::make('register.prompt');
    }

    public function postRegister()
	{
		// TODO: export validation to UserManager

		$rules = array(
			'email' => 'required|email|unique:users,email',
			'password' => 'required|confirmed|min:6'
		);

		$validator = Validator::make(Input::get(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('get.register')
				->withInput()
				->withErrors($validator);
		}


		$credentials = $this->userManager->normalizeCredentials([
			'email' => Input::get('email'),

			// UserManager will handle hashing the password
			'password' => Input::get('password'),

			'activated' => false,
		]);

		try
		{
			$this->userManager->createAccount($credentials);

			FlashHelper::append('alerts.warn', 'Your account has been created, but the email needs to be verified.');

			Auth::attempt($credentials, true);
		}
		catch (Icy\User\UserException $e)
		{
			Log::error('Your account was not created successfully.', ['credentials' => $credentials, 'user_exception' => $e]);
			App::abort(500, 'We were not able to create your account at this time.');
		}

		return View::make('register.success')
			->with('email', $credentials['email']);
	}

	public function activate($code)
	{
		if (!$this->userManager->verifyActivationCodeFormat($code))
			return App::abort(400, 'Malformed activation code.');

		$activated = $this->userManager->activateAccount($code);

		// FIXME: if we redirect to '/', then this alert will be lost in the redirect to '/search'
		FlashHelper::append('alerts.success', 'Your account has been activated.');

		return Redirect::intended('/');
	}

}
