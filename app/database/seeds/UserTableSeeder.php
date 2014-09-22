<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 4:07 AM
 */

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create(array(
			'username' => 'Supericy',
			'email' => 'koise150@hotmail.com',
			'password' => Hash::make('testpassword'),
			'active' => true,
		));
	}

}