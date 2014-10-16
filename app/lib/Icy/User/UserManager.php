<?php namespace Icy\User;

use Illuminate\Hashing\HasherInterface;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;

class UserManager implements IUserManager {

	/**
	 * @var Mailer
	 */
	private $mailer;

	/**
	 * @var HasherInterface
	 */
	private $hasher;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(Mailer $mailer, HasherInterface $hasher, IUserRepository $userRepository)
	{
		$this->mailer = $mailer;
		$this->hasher = $hasher;
		$this->userRepository = $userRepository;
	}

	public function createAccount($credentials)
	{
		$credentials = $this->normalizeCredentials($credentials);

		// basically, assert that we have $creds['password'] and $creds['activated'], since we'll be using those.
		if ($this->userRepository->isMissingFields($credentials, ['email', 'password', 'activated']))
			dd('UserManager::createAccount requires the credentials array to have a password and activated entry.');

		// don't store passwords in plain-text
		$credentials['password'] = $this->hasher->make($credentials['password']);
		$credentials['activation_code'] = $credentials['activated'] ? null : $this->generateActivationCode();

		if (!$this->userRepository->create($credentials))
			throw new UserException('Failed to create new user account.');

		if (!$credentials['activated'])
		{
			$this->sendActivationEmail($credentials['email'], $credentials['activation_code']);
		}

		// perhaps test if the account exists somehow?
		return true;
	}

	public function activateAccount($code)
	{
		return $this->userRepository->activate($code);
	}

	public function sendActivationEmail($email, $code)
	{
		/**
		 * We'll use queue rather than send since we can choose our queue driver in the config, letting us choose
		 * between offloading our emails to a worker or sending immediately via the synchronous driver
		 */
		$this->mailer->queue('emails.activation', ['code' => $code], function ($msg) use ($email) {
			$msg->to($email)
				->subject('Account Activation');
		});
	}

	public function generateActivationCode()
	{
		return Str::random(16);
	}

	public function verifyActivationCodeFormat($code)
	{
		return preg_match('/' . IUserManager::ACTIVATION_CODE_PATTERN . '/', $code);
	}

	public function normalizeCredentials(array $credentials)
	{
		return $this->userRepository->normalize($credentials);
	}

} 