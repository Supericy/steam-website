<?php namespace Icy\BanDetection;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:37 PM
 */

class BanDetectionRepository implements IBanDetectionRepository {

	private $model;

	public function __construct(BanDetection $model)
	{
		$this->model = $model;
	}

	public function firstOrCreate(array $values)
	{
		return $this->model->firstOrCreate($values);
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}
}