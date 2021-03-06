<?php

use Icy\Authentication\IAuthenticationService;
use Icy\User\IUserService;

class RegisterController extends Controller {

	/**
	 * @var IUserService
	 */
	private $userService;
	/**
	 * @var IAuthenticationService
	 */
	private $auth;

	public function __construct(IUserService $userService, IAuthenticationService $auth)
	{
		$this->beforeFilter('guest', ['only' => ['getRegister', 'postRegister']]);
		$this->beforeFilter('csrf', ['only' => ['postRegister']]);

		$this->userService = $userService;
		$this->auth = $auth;
	}

	public function getRegister()
	{
		return View::make('register.prompt');
	}

	public function postRegister()
	{
		// TODO: export validation to UserManager

		$rules = [
			'email' => 'required|email|unique:users,email',
			'password' => 'required|confirmed|min:6'
		];

		$validator = Validator::make(Input::get(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('get.register')
				->withInput()
				->withErrors($validator);
		}


		$credentials = $this->userService->normalizeCredentials([
			'email' => Input::get('email'),

			// UserManager will handle hashing the password
			'password' => Input::get('password'),

			'activated' => false,
		]);

		try
		{
			$userId = $this->userService->createAccount($credentials);

			$this->auth->forceLoginUsingId($userId, true);

			FlashHelper::append('alerts.warn', 'Your account has been created, but the email needs to be verified.');

		} catch (Icy\User\UserException $e)
		{
			Log::error('Your account was not created successfully.', ['credentials' => $credentials, 'user_exception' => $e->getTrace()]);
			App::abort(500, 'We were not able to create your account at this time.');
		}

		return View::make('register.success')
			->with('email', $credentials['email']);
	}

	public function activate($code)
	{
		if (!$this->userService->verifyActivationCodeFormat($code))
			return App::abort(400, 'Malformed activation code.');

		$activated = $this->userService->activateAccount($code);

		// FIXME: if we redirect to '/', then this alert will be lost in the redirect to '/search'
		FlashHelper::append('alerts.success', 'Your account has been activated.');

		return Redirect::intended('/');
	}

}
