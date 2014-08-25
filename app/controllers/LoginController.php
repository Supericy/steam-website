<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/19/14
 * Time: 2:59 AM
 */

class LoginController extends \BaseController {

    public function getLogin()
    {
        if (Auth::check())
        {
            return 'you are already logged in';
        }

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

        $remember = true;

        $auth = Auth::attempt(array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ), $remember);

        if ($auth)
        {
            // logged in

//            return View::make('login.success');
        }
        else
        {
            return 'could not authenticate';
        }
    }

} 