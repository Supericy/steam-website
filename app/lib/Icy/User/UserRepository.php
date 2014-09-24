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

	public function create(array $values)
	{
		$credentials = $this->normalize($values);

		return $this->model->create($values);
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
		$credentials['email'] = Str::lower($credentials['email']);

		return $credentials;
	}

}