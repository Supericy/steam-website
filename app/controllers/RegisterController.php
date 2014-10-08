<?php

use \Illuminate\Support\Str;

class RegisterController extends Controller {

	const ACTIVATION_CODE_PATTERN = '[A-Za-z0-9]{16}';

	private $user;
	private $activationManager;
	private $activationCode;

	public function __construct(Icy\User\IUserRepository $user, Icy\User\IActivationManager $activationManager, Icy\User\IActivationCodeRepository $activationCode)
	{
		$this->user = $user;
		$this->activationManager = $activationManager;
		$this->activationCode = $activationCode;
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

		$userRecord = $this->user->create(array(
			'email' => Str::lower(Input::get('email')),
			'password' => Hash::make(Input::get('password')),
			'active' => false
		));

		$activationCodeRecord = $this->activationManager->createActivationCode($userRecord->id);
		$this->activationManager->sendActivationEmail($userRecord->email, $activationCodeRecord->code);

		FlashHelper::append('alerts.warn', 'Your account has been created, but needs to be verified.');

		return View::make('register.success')
			->with('email', $userRecord->email);
	}

	public function activate($code)
	{
		if (preg_match('/' . self::ACTIVATION_CODE_PATTERN . '/', $code))
		{
			$activationCodeRecord = $this->activationCode->getByCode($code);

			if ($activationCodeRecord)
			{
				if ($this->activationManager->activate($activationCodeRecord))
				{
					$userRecord = $activationCodeRecord->user()->first();

					Auth::login($userRecord);

					FlashHelper::append('alerts.success', 'Your account has been activated.');

					return Redirect::intended('/');
				}
				else
				{
					return App::abort(403, 'Activation code could not be activated.');
				}
			}
		}

		return App::abort(500, 'Activation code not found.');
	}

}
