<?php namespace Icy\User;
use Icy\Common\AbstractCachedRepository;
use Illuminate\Auth\UserInterface;
use Illuminate\Cache\CacheManager;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/7/2014
 * Time: 4:00 AM
 */

class CachedUserRepository extends AbstractCachedRepository implements IUserRepository {

	const USER_DURATION = 60;

	/**
	 * @var IUserRepository
	 */
	private $repository;

	public function __construct(CacheManager $cache, IUserRepository $repository)
	{
		parent::__construct($cache);
		$this->repository = $repository;
	}

	public function getById($id)
	{
		return $this->cache()->remember($this->generateUserCacheKey($id), self::USER_DURATION, function () use ($id)
		{
			return $this->repository->getById($id);
		});
	}

	/**
	 * @param $code
	 *        The activation code for the user we want to activate.
	 * @return bool
	 *        Returns true if a user was successfully activated, false in every other case
	 */
	public function activate($code)
	{
		return $this->repository->activate($code);
	}

	public function getByEmail($email)
	{
		return $this->repository->getByEmail($email);
	}

	public function create(array $values)
	{
		return $this->repository->create($values);
	}

	public function getByProviderNameAndAccountId($provider, $accountId)
	{
		return $this->repository->getByProviderNameAndAccountId($provider, $accountId);
	}

	public function normalize($credentials)
	{
		return $this->repository->normalize($credentials);
	}

	/**
	 * Checks whether the credentials passed in contains all the nessessary fields (array keys). This method does NOT
	 * check data types.
	 *
	 * @param array $credentials
	 *        Array of credentials we want to check
	 * @return bool
	 */
	public function isMissingFields(array $credentials)
	{
		return $this->repository->isMissingFields($credentials);
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function save(User $user)
	{
		$this->cache()->forget($this->generateUserCacheKey($user->getAuthIdentifier()));

		return $this->repository->save($user);
	}

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed $identifier
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveById($identifier)
	{
		return $this->getById($identifier);
	}

	/**
	 * Retrieve a user by by their unique identifier and "remember me" token.
	 *
	 * @param  mixed $identifier
	 * @param  string $token
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByToken($identifier, $token)
	{
		$user = $this->retrieveById($identifier);

		if ($user && $user->getRememberToken() === $token)
		{
			return $user;
		}

		return null;
	}

	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Illuminate\Auth\UserInterface $user
	 * @param  string $token
	 * @return void
	 */
	public function updateRememberToken(UserInterface $user, $token)
	{
		$this->repository->updateRememberToken($user, $token);
	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array $credentials
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		return $this->repository->retrieveByCredentials($credentials);
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Auth\UserInterface $user
	 * @param  array $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials)
	{
		return $this->repository->validateCredentials($user, $credentials);
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function generateUserCacheKey($id)
	{
		return 'user_' . $id;
	}
}