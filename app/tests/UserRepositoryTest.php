<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 10:44 PM
 */

class UserRepositoryTest extends TestCase {

	/**
	 * @group user_repo
	 */
	public function testGetByProviderAccountId()
	{
		$user = $this->app->make('Icy\User\IUserRepository');

		try
		{
			$record = $user->getByProviderNameAndAccountId('google', 1337);
		}
		catch (PDOException $e)
		{
			echo $e->getMessage() . "\n";
		}
	}

}