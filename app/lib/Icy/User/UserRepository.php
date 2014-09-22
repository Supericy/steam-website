<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

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
		return $this->model->create($values);
	}

	public function getByEmail($email)
	{
		return $this->model->where('email', $email)->first();
	}

	public function getByProviderAccountId($provider, $accountId)
	{
		return $this->model->whereHas('oauthProviders', function ($q) use ($provider, $accountId) {
			$q->where('account_id', $accountId)
				->where('oauth_providers.name', $provider);
		})->first();
	}

}