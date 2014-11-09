<?php namespace Icy\Ban;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 11:49 PM
 */

interface IBanTypeRepository {

	/**
	 * @param string $name
	 * @return BanType
	 */
	public function getByName($name);

	/**
	 * @return Collection
	 */
	public function getAll();

} 