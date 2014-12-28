<?php namespace Kosiec\Service;
use Kosiec\Common\PasswordHasher;
use Kosiec\Repository\IUserAccountRepository;
use Illuminate\Hashing\HasherInterface;
use Illuminate\Mail\Mailer;
use Kosiec\Entity\UserAccount;
use Kosiec\ValueObject\ActivationCode;
use Illuminate\Mail\Message;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 5:59 PM
 */

class UserAccountService {

	/**
	 * @var Mailer
	 */
	private $mailer;
	/**
	 * @var \Kosiec\Repository\IUserAccountRepository
	 */
	private $userAccountRepository;
	/**
	 * @var PasswordHasher
	 */
	private $hasher;

	/**
	 * @param Mailer $mailer
	 * @param IUserAccountRepository $userAccountRepository
	 * @param PasswordHasher $hasher
	 */
	public function __construct(Mailer $mailer, IUserAccountRepository $userAccountRepository, PasswordHasher $hasher)
	{
		$this->mailer = $mailer;
		$this->userAccountRepository = $userAccountRepository;
		$this->hasher = $hasher;
	}

	public function createAccount(UserAccountCredentials $credentials)
	{
		$userAccount = new UserAccount($credentials->getEmail(), $this->hasher->hash($credentials->getPassword()), ActivationCode::generate());

		$this->userAccountRepository->store($userAccount);

		return $userAccount;
	}

	public function sendActivationEmail(UserAccount $userAccount)
	{
		if ($userAccount->isActive())
			return;

		$this->mailer->queue('emails.activation', ['code' => $userAccount->getActivationCode()->__toString()], function (Message $message) use ($userAccount)
		{
			$message->to($userAccount->getEmail()->__toString())
					->subject('Account Activation');
		});
	}

	public function activateAccount(ActivationCode $activationCode)
	{
		$userAccount = $this->userAccountRepository->findByActivationCode($activationCode);

		if ($userAccount)
		{
			$userAccount->activate();
			$this->userAccountRepository->store($userAccount);
		}
	}

}