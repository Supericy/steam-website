<?php

use Icy\Common\AbstractEntityFactory;

/**
 * Class AbstractEntityFactoryTest
 * @group AbstractEntityFactory
 */
class AbstractEntityFactoryTest extends PHPUnit_Framework_TestCase {

	public function test_setFields()
	{
		$object = (object)[
			'testField1' => 'oldValue',
			'testField2' => 'oldValue'
		];

		$abstractEntityFactory = $this->getMockForAbstractClass('Icy\Common\AbstractEntityFactory');

		$abstractEntityFactory
			->expects($this->any())
			->method('create')
			->will($this->returnValue(true));

		$reflectionObject = new ReflectionObject($abstractEntityFactory);

		$method = $reflectionObject->getMethod('setFields');
		$method->setAccessible(true);

		$method->invokeArgs($abstractEntityFactory, [$object, [
			'testField1' => 'newValue',
			'testField2' => 'newValue'
		]]);

		$this->assertSame('newValue', $object->testField1);
		$this->assertSame('newValue', $object->testField2);
	}

}
 