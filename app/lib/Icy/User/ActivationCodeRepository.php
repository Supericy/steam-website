<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/27/2014
 * Time: 10:53 PM
 */



class ActivationCodeRepository implements IActivationCodeRepository {

	private $model;

	public function __construct(ActivationCode $model)
	{
		$this->model = $model;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

	public function getByCode($code)
	{
		return $this->model->where('code', $code)->first();
	}

} 