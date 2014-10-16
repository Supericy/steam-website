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
	private $userRepository;
	private $activationCodeRepository;

	public function __construct(\Illuminate\Mail\Mailer $mailer, IUserRepository $userRepository, IActivationCodeRepository $activationCodeRepository)
	{
		$this->mailer = $mailer;
		$this->userRepository = $userRepository;
		$this->activationCodeRepository = $activationCodeRepository;
	}

	public function createActivationCode($userId)
	{
		$code = Str::random(16);

		// TODO: handle duplicates? (rare but -possible-)
		$this->activationCodeRepository->create([
			'user_id' => $userId,
			'code' => $code,
		]);

		return $code;
	}

	public function sendActivationEmail($email, $code)
	{
		$this->mailer->send('emails.activation', ['code' => $code], function ($msg) use ($email) {
			$msg->to($email)
				->subject('Account Activation');
		});
	}

	public function createAndSendActivationCode($userId, $email)
	{
		$code = $this->createActivationCode($userId);
		$this->sendActivationEmail($email, $code);
	}

	public function activate($code)
	{
		if ($code instanceof ActivationCode)
			$activationCodeRecord = $code;
		else
			$activationCodeRecord = $this->activationCodeRepository->getByCode($code);

		$activated = false;

		if ($activationCodeRecord)
		{
			$userRecord = $activationCodeRecord->user()->first();

			$userRecord->active = true;

			$this->userRepository->save($userRecord);
			$this->activationCodeRepository->delete($activationCodeRecord);

			$activated = true;
		}

		return $activated;
	}

}