<?php namespace Kosiec\Entity;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/27/2014
 * Time: 1:22 AM
 */

abstract class AbstractEntity {

	protected function convertAndReturnValueObject(&$value, $callback)
	{
		if (is_string($value))
			$value = $callback($value);

		return $value;
	}

}