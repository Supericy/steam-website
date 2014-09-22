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
		$user = $this->app->make('Icy\User\UserRepository');

		try
		{
			$record = $user->getByProviderAccountId('google', 1337);

			if ($record)
				print $record->username . "\n";
			else
				print "no user found";
		}
		catch (PDOException $e)
		{
			echo $e->getMessage() . "\n";
		}
	}

}