<?php
use Kosiec\Common\PasswordHasher;
use Kosiec\ValueObject\Password;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/26/2014
 * Time: 1:32 AM
 */

class PasswordHasherTest extends TestCase {

	public function test_HashPassword()
	{
		$hasher = new PasswordHasher();

		$hash = $hasher->hash(new Password('password'));
		$this->assertTrue($hasher->verify(new Password('password'), $hash));

		$hash2 = $hasher->hash(new Password('password'));
		$this->assertFalse($hasher->verify(new Password('not the same'), $hash2));
	}

}