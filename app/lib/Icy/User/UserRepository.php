<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

use \Illuminate\Support\Str;

class UserRepository implements IUserRepository {

	private static $_CREDENTIAL_FIELDS = [
		'email',
		'password',
		'activated',
		'activation_code'
	];

	private $model;

	public function __construct(User $model)
	{
		$this->model = $model;
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
			$userRecord->activated = true;
			$userRecord->activation_code = null;

			$this->save($userRecord);

			$activated = true;
		}

		return $activated;
	}

	public function getByActivationCode($code)
	{
		return $this->model->where('activation_code', $code)->first();
	}

	public function getByAuthToken($token)
	{
		return $this->model->whereHas('authTokens', function ($q) use ($token) {
			$q->where('token', $token);
		})->first();
	}

	// returns an array with only the data needed to create a user
	private function removeUnused(array $credentials)
	{
		return array_filter($credentials, function ($key) {
			return in_array($key, self::$_CREDENTIAL_FIELDS);
		}, \ARRAY_FILTER_USE_KEY);
	}

	public function firstOrCreate(array $credentials)
	{
		$credentials = $this->normalize($credentials);

		return $this->model->firstOrCreate($this->removeUnused($credentials));
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

	public function getByProviderNameAndAccountId($providerName, $accountId)
	{
		return $this->model->whereHas('oauthProviders', function ($q) use ($providerName, $accountId) {
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
		return $user->save();
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

}