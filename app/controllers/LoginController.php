<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */

class LoginController extends Controller {

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
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make(Input::get(), $rules);

        if ($validator->fails())
        {
            return Redirect::route('get.login')->withInput()->withErrors($validator);
        }

        $auth = Auth::attempt(array(
            'email' => Input::get('email'),
            'password' => Input::get('password'),
			'active' => true
        ), true);

        if ($auth)
        {
            FlashHelper::append('alerts.success', 'You have been logged in.');

            return Redirect::intended('/');
        }
        else
        {
            return Redirect::route('get.login')->withInput()->withErrors(['login' => ['Invalid e-mail or password.']]);
        }
    }

} 