<?php namespace Icy\Common\Eloquent;

use Icy\Common\IEntity;
use Icy\Common\IEntityFactory;
use Icy\Common\IEntityTranslator;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 3:17 AM
 */

class EloquentEntityTranslator implements IEntityTranslator {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var IEntityFactory
	 */
	private $entityFactory;

	public function __construct(Model $model, IEntityFactory $entityFactory)
	{
		$this->model = $model;
		$this->entityFactory = $entityFactory;
	}

	public function toEntity(array $values)
	{
		return $this->entityFactory->create($values);
	}

	public function fromEntity(IEntity $entity)
	{
		return $this->model->newInstance($entity->toArray());
	}

}