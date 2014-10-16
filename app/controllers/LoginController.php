<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */

class LoginController extends Controller {

	/**
	 * @var \Icy\User\IUserManager
	 */
	private $userManager;

	public function __construct(Icy\User\IUserManager $userManager)
	{
		$this->userManager = $userManager;
	}

    public function logout()
    {
        Auth::logout();

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
		// TODO: export validation to our UserManager class

        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make(Input::get(), $rules);

        if ($validator->fails())
        {
            return Redirect::route('get.login')
				->withInput()
				->withErrors($validator);
        }

		$credentials = $this->userManager->normalizeCredentials([
			'email' => Input::get('email'),

			// note that we don't hash the password when using Auth::attempt()
			'password' => Input::get('password')
		]);

        if (Auth::attempt($credentials, true))
        {
            FlashHelper::append('alerts.success', 'You have been logged in.');

			// TODO: prompt with activation alert if their email/account needs activation

            return Redirect::intended('/');
        }
        else
        {
            return Redirect::route('get.login')
				->withInput()
				->withErrors([
					'login' => ['Incorrect e-mail or password.']
				]);
        }
    }

} 