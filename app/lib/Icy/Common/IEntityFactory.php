<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 3:42 AM
 */

interface IEntityFactory {

	/**
	 * @param array $values
	 * @return IEntity
	 */
	public function create(array $values);

} 