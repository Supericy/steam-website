<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:02 AM
 */

class OAuthAccountRepository implements IOAuthAccountRepository {

	private $model;

	public function __construct(OAuthAccount $model)
	{
		$this->model = $model;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}
}