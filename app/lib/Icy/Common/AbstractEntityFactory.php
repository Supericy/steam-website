<?php namespace Icy\Common;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 3:48 AM
 */

abstract class AbstractEntityFactory implements IEntityFactory {

	protected function setFields($obj, array $fields)
	{
		$reflectionObject   = new \ReflectionObject($obj);

		foreach ($fields as $key => $value)
		{
			$property = $reflectionObject->getProperty($key);
			$property->setAccessible(true);
			$property->setValue($obj, $value);
		}
	}

}