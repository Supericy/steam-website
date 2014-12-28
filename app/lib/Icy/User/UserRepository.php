<?php namespace Icy\User;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

use Illuminate\Auth\UserInterface;
use Illuminate\Hashing\HasherInterface;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository {

	private static $_CREDENTIAL_FIELDS = [
		'email',
		'password',
		'activated',
		'activation_code'
	];

	private $model;
	/**
	 * @var HasherInterface
	 */
	private $hasher;

	public function __construct(User $model, HasherInterface $hasher)
	{
		$this->model = $model;
		$this->hasher = $hasher;
	}

	public function getById($id)
	{
		return $this->model->where('id', $id)->first();
	}

	public function activate($code)
	{
		/**
		 * This function could easily be optimized into a single query by just updating activated=true
		 * where activation_code=$code, rather than fetching the user object and then saving it back.
		 */

		$userRecord = $this->getByActivationCode($code);

		$activated = false;

		if ($userRecord)
		{
			$userRecord->activate();

			$this->save($userRecord);

			$activated = true;
		}

		return $activated;
	}

	public function create(array $values)
	{
		$credentials = $this->normalize($values);

		if ($this->isMissingFields($values))
			throw new UserException('There are fields missing from the provided credentials.');

		return $this->model->create($this->removeUnused($credentials));
	}

	public function getByEmail($email)
	{
		return $this->model->where('email', $email)->first();
	}

	public function getIdByProviderNameAndAccountId($providerName, $accountId)
	{
		$record = $this->getByProviderNameAndAccountId($providerName, $accountId);

		return $record ? $record->id() : false;
	}

	public function getByProviderNameAndAccountId($providerName, $accountId)
	{
		return $this->model->whereHas('oauthProviders', function ($q) use ($providerName, $accountId)
		{
			$q->where('account_id', $accountId)
				->where('oauth_providers.name', $providerName);
		})->first();
	}

	public function normalize($credentials)
	{
		if (array_key_exists('email', $credentials))
			$credentials['email'] = Str::lower($credentials['email']);

		return $credentials;
	}

	public function save(User $user)
	{
		return $user->push();
	}

	public function isMissingFields(array $credentials, array $fields = [])
	{
		$_fields = !empty($fields) ? $fields : self::$_CREDENTIAL_FIELDS;

		foreach ($_fields as $field)
		{
			if (!array_key_exists($field, $credentials))
				return true;
		}

		return false;
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
		$user->setRememberToken($token);

		$this->save($user);
	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array $credentials
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		// taken from EloquentUserProvider

		// First we will add each credential element to the query as a where clause.
		// Then we can execute the query and, if we found a user, return it in a
		// Eloquent User "model" that will be utilized by the Guard instances.
		$query = $this->model->newQuery();

		foreach ($credentials as $key => $value)
		{
			if ( ! str_contains($key, 'password')) $query->where($key, $value);
		}

		return $query->first();
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
		$plain = $credentials['password'];

		return $this->hasher->check($plain, $user->getAuthPassword());
	}

	/**
	 * @param array $credentials
	 * @return array
	 * 			Array with unused entries filtered out
	 */
	private function removeUnused(array $credentials)
	{
		return array_filter($credentials, function ($key)
		{
			return in_array($key, self::$_CREDENTIAL_FIELDS);
		}, \ARRAY_FILTER_USE_KEY);
	}

	/**
	 * @param $code
	 * @return \Icy\User\User
	 */
	private function getByActivationCode($code)
	{
		return $this->model->where('activation_code', $code)->first();
	}

}