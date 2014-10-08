<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/27/2014
 * Time: 8:37 PM
 */

use \Illuminate\Support\Str;

class ActivationManager implements IActivationManager {

	private $mailer;
	private $activationCode;

	public function __construct(\Illuminate\Mail\Mailer $mailer, IActivationCodeRepository $activationCode)
	{
		$this->mailer = $mailer;
		$this->activationCode = $activationCode;
	}

	public function createActivationCode($userId)
	{
		// TODO: handle duplicates? (rare but -possible-)
		return $this->activationCode->create([
			'user_id' => $userId,
			'code' => Str::random(16),
		]);
	}

	public function sendActivationEmail($email, $code)
	{
		$this->mailer->send('emails.activation', ['code' => $code], function ($msg) use ($email) {
			$msg->to($email)
				->subject('Account Activation');
		});
	}

	public function activate($code)
	{
		if ($code instanceof ActivationCode)
			$activationCodeRecord = $code;
		else
			$activationCodeRecord = $this->activationCode->getByCode($code);

		$activated = false;

		if ($activationCodeRecord)
		{
			$userRecord = $activationCodeRecord->user()->first();

			$userRecord->active = true;

			$userRecord->save();
			$activationCodeRecord->delete();

			$activated = true;
		}

		return $activated;
	}

} 