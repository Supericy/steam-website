<?php

class RegisterController extends Controller {

	private $user;

	public function __construct(Icy\User\IUserRepository $user)
	{
		$this->user = $user;
	}

    public function getRegister()
    {
        return View::make('register.prompt');
    }

    public function postRegister()
	{
		$rules = array(
			'email' => 'required|email|unique:users,email',
			'password' => 'required|confirmed|min:6'
		);

		$validator = Validator::make(Input::get(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('get.register')->withInput()->withErrors($validator);
		}

		// TODO: generate activation token and..
		// TODO: send email verification, set account to NOT ACTIVE until they've verified it
		$user = $this->user->create(array(
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'active' => true
		));

		return Redirect::action('register.activate');
	}

	public function activate($activationToken)
	{
		dd('not implemented, accounts are active by default');
	}

}
