<?php namespace Icy\Esea;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/1/2014
 * Time: 1:34 AM
 */



class EseaBanRepository implements IEseaBanRepository {

	private $model;

	public function __construct(EseaBan $model)
	{
		$this->model = $model;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

} 