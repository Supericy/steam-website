<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

use \Illuminate\Support\Str;

class UserRepository implements IUserRepository {

	private $model;

	public function __construct(User $model)
	{
		$this->model = $model;
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
		return [
			'email' => $credentials['email'],
			'password' => $credentials['password'],
			'active' => $credentials['active'],
		];
	}

	public function firstOrCreate(array $credentials)
	{
		$credentials = $this->normalize($credentials);

		return $this->model->firstOrCreate($this->removeUnused($credentials));
	}

	public function create(array $values)
	{
		$credentials = $this->normalize($values);

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

	/**
	 * @param User $user
	 * @return bool
	 */
	public function save(User $user)
	{
		return $user->save();
	}

}