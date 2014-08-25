<?php

class RegisterController extends \BaseController {

    public function getRegister()
    {
        return View::make('register.prompt');
    }

    public function postRegister()
    {
        $rules = array(
            'username' => 'required|alpha_num|min:6|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        );

        $validator = Validator::make(Input::get(), $rules);

        if ($validator->fails())
        {
            return Redirect::route('get.register')->withInput()->withErrors($validator);
        }

        $user = User::create(array(
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password'))
        ));

        return View::make('register.success');
    }

}
