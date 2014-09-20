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

}