<?php
use Icy\Authentication\AuthenticationException;
use Icy\Authentication\IAuthenticationService;
use Icy\User\IUserService;
use Illuminate\Routing\Controller;
use Kosiec\Common\PasswordHasher;
use Kosiec\Factory\UserAccountCredentialsFactory;
use Kosiec\Service\Authentication\InvalidUserAccountCredentialsException;
use Kosiec\Service\Authentication\UserAccountNotActiveException;
use Kosiec\Service\AuthenticationService;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */
class LoginController extends Controller {

	/**
	 * @var AuthenticationService
	 */
	private $auth;
	/**
	 * @var UserAccountCredentialsFactory
	 */
	private $credentialsFactory;

	public function __construct(AuthenticationService $auth, UserAccountCredentialsFactory $credentialsFactory)
	{
		$this->beforeFilter('guest', ['only' => ['loginPrompt', 'login']]);
		$this->beforeFilter('csrf', ['only' => ['login']]);
		$this->beforeFilter('auth', ['only' => ['logout']]);

		$this->auth = $auth;
		$this->credentialsFactory = $credentialsFactory;
	}

	public function logout()
	{
		$this->auth->logout();

		FlashHelper::append('alerts.success', 'You have been logged out.');

		return Redirect::back();
	}

	public function loginPrompt()
	{
		$displayLoginMethod = Session::get('displayLoginMethod', []);

		return View::make('login.prompt')
			->with('displayLoginMethod', $displayLoginMethod)
			->with('activationCode', Session::get('activationCode', null));
	}

	public function login()
	{
		$validator = Validator::make(Input::all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if ($validator->fails())
		{
			return Redirect::route('user.login-prompt')
				->withInput()
				->withErrors($validator);
		}

		$credentials = $this->credentialsFactory->create(Input::get('email'), Input::get('password'));
		if ( ! $this->auth->authenticate($credentials, true))
		{
			return Redirect::route('user.login-prompt')
				->withInput()
				->withErrors([
					'login' => $this->auth->getErrors(),
				])
				->with('activationCode', $this->auth->getActivationCode());
		}

		FlashHelper::append('alerts.success', 'You have been logged in.');

		return Redirect::intended('/');
	}

} 