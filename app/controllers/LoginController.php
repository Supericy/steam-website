<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */

class LoginController extends \BaseController {

    public function logout()
    {
        Auth::logout();

        FlashHelper::append('alerts.success', 'You have been logged out.');

        return Redirect::back();
    }

    public function getLogin()
    {
        return View::make('login.prompt');
    }

    public function postLogin()
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );

        $validator = Validator::make(Input::get(), $rules);

        if ($validator->fails())
        {
            return Redirect::route('get.login')->withInput()->withErrors($validator);
        }

        $auth = Auth::attempt(array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ), true);

        if ($auth)
        {
            FlashHelper::append('alerts.success', 'You have been logged in.');

            // logged in
//            return View::make('login.success');
            return Redirect::route('home');
        }
        else
        {
            return Redirect::route('get.login')->withInput()->withErrors(['login' => ['Invalid username or password.']]);
        }
    }

} 