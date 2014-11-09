<?php namespace Icy\Ban;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 11:49 PM
 */

class BanTypeRepository implements IBanTypeRepository {

	private $model;

	public function __construct(BanType $model)
	{
		$this->model = $model;
	}

	public function getByName($name)
	{
		$record = $this->model->where('name', $name)->remember(3600)->first();

		if (!$record)
			throw new InvalidBanTypeException('"' . $name . '" is not a valid ban type');

		// this is a table of constants, so let's cache this value for a -long- time.
		return $record;
	}

	public function getAll()
	{
		return $this->model->all();
	}

}