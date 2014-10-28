<?php
use Icy\Authentication\AuthenticationException;
use Icy\Authentication\IAuthenticationService;
use Icy\User\IUserService;
use Illuminate\Routing\Controller;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */
class LoginController extends Controller {

	/**
	 * @var IAuthenticationService
	 */
	private $auth;

	public function __construct(IAuthenticationService $auth)
	{
		$this->beforeFilter('guest', ['only' => ['getLogin', 'postLogin']]);
		$this->beforeFilter('csrf', ['only' => ['postLogin']]);
		$this->beforeFilter('auth', ['only' => ['logout']]);

		$this->auth = $auth;
	}

	public function logout()
	{
		$this->auth->logout();

		FlashHelper::append('alerts.success', 'You have been logged out.');

		return Redirect::back();
	}

	public function getLogin()
	{
		$displayLoginMethod = Session::get('displayLoginMethod', []);

		return View::make('login.prompt')
			->with('displayLoginMethod', $displayLoginMethod);
	}

	public function postLogin()
	{
		$rules = [
			'email' => 'required|email',
			'password' => 'required'
		];

		$validator = Validator::make(Input::get(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('get.login')
				->withInput()
				->withErrors($validator);
		}

		$credentials = [
			'email' => Input::get('email'),

			// note that we don't hash the password when using Auth::attempt()
			'password' => Input::get('password')
		];

		try
		{
			$this->auth->login($credentials, true);

			FlashHelper::append('alerts.success', 'You have been logged in.');

			// TODO: prompt with activation alert if their email/account needs activation
		}
		catch (AuthenticationException $e)
		{
			return Redirect::route('get.login')
				->withInput()
				->withErrors([
					'login' => [$e->getMessage()]
				]);
		}

		return Redirect::intended('/');
	}

} 