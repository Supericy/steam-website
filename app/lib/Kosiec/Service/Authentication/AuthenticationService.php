<?php namespace Kosiec\Service;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Guard;
use Illuminate\Support\Collection;
use Kosiec\Common\PasswordHasher;
use Kosiec\Entity\UserAccount;
use Kosiec\Repository\IUserAccountRepository;
use Kosiec\ValueObject\ActivationCode;
use Kosiec\ValueObject\Email;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 7:01 PM
 */

class AuthenticationService {

	const INCORRECT_CREDENTIALS_ERROR = 'The email or password you entered is incorrect';
	const NOT_ACTIVE_ERROR = 'Account is not active, please activate it';

	/**
	 * @var Guard
	 */
	private $auth;
	/**
	 * @var IUserAccountRepository
	 */
	private $userAccountRepository;
	/**
	 * @var ActivationCode|null
	 */
	private $activationCode;
	/**
	 * @var Collection
	 */
	private $errors;
	/**
	 * @var PasswordHasher
	 */
	private $hasher;

	/**
	 * @param AuthManager $auth
	 * @param IUserAccountRepository $userAccountRepository
	 * @param PasswordHasher $hasher
	 */
	function __construct(AuthManager $auth, IUserAccountRepository $userAccountRepository, PasswordHasher $hasher)
	{
		$this->auth = $auth;
		$this->userAccountRepository = $userAccountRepository;

		$this->errors = new Collection();
		$this->activationCode = null;
		$this->hasher = $hasher;
	}

	/**
	 * @return UserAccount|null
	 */
	public function currentUser()
	{
		return $this->auth->user();
	}

	/**
	 *
	 */
	public function logout()
	{
		$this->auth->logout();
	}

	/**
	 * @param UserAccountCredentials $credentials
	 * @param bool $remember
	 * @return bool
	 */
	public function authenticate(UserAccountCredentials $credentials, $remember = true)
	{
		$userAccount = $this->userAccountRepository->findByEmail($credentials->getEmail());

		if ( ! $userAccount || ! $this->hasher->verify($credentials->getPassword(), $userAccount->getPasswordHash()))
		{
			$this->errors->push(self::INCORRECT_CREDENTIALS_ERROR);
			return false;
		}

		if ( ! $userAccount->isActive())
		{
			$this->errors->push(self::NOT_ACTIVE_ERROR);
			$this->activationCode = $userAccount->getActivationCode();
			return false;
		}

		// success
		$this->auth->login($userAccount, $remember);
		return true;
	}

	/**
	 * @return string[] errors
	 */
	public function getErrors()
	{
		return $this->errors->toArray();
	}

	/**
	 * @return ActivationCode|null
	 */
	public function getActivationCode()
	{
		return $this->activationCode;
	}
}