<?php namespace Icy\BanDetection;
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

	/**
	 * @param string $name
	 * @return BanType
	 */
	public function getByName($name)
	{
		// this is a table of constants, so let's cache this value for a -long- time.
		return $this->model->where('name', $name)->remember(3600)->first();
	}

	/**
	 * @return BanType[]
	 */
	public function getAll()
	{
		return $this->model->all();
	}

}