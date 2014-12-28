<?php

use Illuminate\Hashing\HasherInterface;
use Kosiec\Common\PasswordHasher;
use Kosiec\Factory\UserAccountCredentialsFactory;
use Kosiec\Service\AuthenticationService;
use Kosiec\Service\UserAccountCredentials;
use Kosiec\Service\UserAccountService;
use Kosiec\ValueObject\ActivationCode;
use Kosiec\ValueObject\Email;
use Kosiec\ValueObject\PasswordHash;

class RegisterController extends Controller {

	/**
	 * @var UserAccountService
	 */
	private $userAccountService;
	/**
	 * @var UserAccountCredentialsFactory
	 */
	private $credentialsFactory;

	/**
	 * @param UserAccountService $userAccountService
	 * @param UserAccountCredentialsFactory $credentialsFactory
	 */
	public function __construct(
		UserAccountService $userAccountService,
		UserAccountCredentialsFactory $credentialsFactory)
	{
		$this->beforeFilter('guest', ['only' => ['create', 'store']]);
		$this->beforeFilter('csrf', ['only' => ['store']]);

		$this->userAccountService = $userAccountService;
		$this->credentialsFactory = $credentialsFactory;
	}

	public function registerPrompt()
	{
		return View::make('register.prompt');
	}

	public function register()
	{
		$validator = Validator::make(Input::all(), [
			'email' => 'required|email|unique:user_account,email',
			'password' => 'required|confirmed|min:6'
		]);

		if ($validator->fails())
		{
			return Redirect::route('user.register-prompt')
				->withInput()
				->withErrors($validator);
		}

		$credentials = $this->credentialsFactory->create(Input::get('email'), Input::get('password'));
		$userAccount = $this->userAccountService->createAccount($credentials);
		$this->userAccountService->sendActivationEmail($userAccount);

		FlashHelper::append('alerts.warn', 'Your account has been created, but is not yet active');

		return View::make('register.success')
			->with('email', $credentials->getEmail());
	}

	public function activate($code)
	{
		$validator = Validator::make(['activation_code' => $code], [
			'activation_code' => 'required|regex:' . ActivationCode::PATTERN
		]);

		if ($validator->fails())
		{
			App::abort(400, $validator);
		}

		$activationCode = new ActivationCode($code);

		$this->userAccountService->activateAccount($activationCode);

//		if (!$this->userService->verifyActivationCodeFormat($code))
//			return App::abort(400, 'Malformed activation code.');

//		$activated = $this->userService->activateAccount($code);

		// FIXME: if we redirect to '/', then this alert will be lost in the redirect to '/search'
		FlashHelper::append('alerts.success', 'Your account has been activated.');

		return Redirect::intended('/');
	}

}
