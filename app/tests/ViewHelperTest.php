<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 4:45 AM
 */

/**
 * Class ViewHelperTest
 * @group ViewHelper
 */
class ViewHelperTest extends TestCase {

	// FIXME: ViewHelper isn't being included
	public function test_displayArray()
	{
		$array = [
			'item 1',
			'item 2',
			'item 3'
		];

		$format = '<div>:message</div>';

		$expected = '<div>item 1</div><div>item 2</div><div>item 3</div>';

		$this->assertSame($expected, ViewHelper::displayArray($array, $format));
	}

	public function test_displayAlerts()
	{

	}

}
 