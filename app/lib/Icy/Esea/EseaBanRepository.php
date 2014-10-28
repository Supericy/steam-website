<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/1/2014
 * Time: 1:34 AM
 */
namespace Icy\Esea;


class EseaBanRepository implements IEseaBanRepository {

	private $model;

	public function __construct(EseaBan $model)
	{
		$this->model = $model;
	}

	public function getLatestTimestamp()
	{
		$timestamp = $this->model->max('timestamp');
		return $timestamp === NULL ? 0 : $timestamp;
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

} 