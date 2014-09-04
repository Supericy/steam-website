<?php namespace Icy\BanListener;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:58 PM
 */

class BanListenerRepository implements IBanListenerRepository {

	private $model;

	public function __construct(BanListener $model)
	{
		$this->model = $model;
	}

	public function firstOrCreate(array $values)
	{
		return $this->model->firstOrCreate($values);
	}
}