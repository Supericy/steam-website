<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 3:12 AM
 */

interface IEntityTranslator {

	/**
	 * @param array $values
	 * @return IEntity
	 */
	public function toEntity(array $values);

	/**
	 * @param IEntity $entity
	 * @return mixed
	 */
	public function fromEntity(IEntity $entity);

} 