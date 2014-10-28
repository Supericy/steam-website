<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:13 AM
 */


/**
 * Class TestState
 */
class TestState extends \Icy\Steam\Web\States\AbstractState {

	protected $states = [
		0 => 'Expected State 0',
		1 => 'Expected State 1'
	];

}

/**
 * Class StateTest
 * @group StateTest
 */
class StateTest extends TestCase {

	public function test_createStateFromInteger()
	{
		$state = TestState::fromInteger(0);
		$this->assertSame(0, $state->integer());
		$this->assertSame('Expected State 0', $state->string());

		$state = TestState::fromInteger(1);
		$this->assertSame(1, $state->integer());
		$this->assertSame('Expected State 1', $state->string());
	}

} 