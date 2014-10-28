<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/20/2014
 * Time: 5:11 PM
 */

class DatabaseTestCase extends TestCase {

	public function setUp()
	{
		parent::setUp();

		Artisan::call('migrate');
	}

} 