<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 3:18 PM
 */

abstract class AbstractRepository {

	public function toObject(array $arr)
	{
		return \json_decode(\json_encode($arr));
	}

} 