<?php
use Carbon\Carbon;

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

		DB::table('users')->insert([
			$this->createRecordArray('koise150@hotmail.com', 'testpassword', 1, null),
		]);
	}

	private function createRecordArray($email, $password, $activated, $activationCode)
	{
		return [
			'email' => $email,
			'password' => Hash::make($password),
			'activated' => $activated,
			'activation_code' => $activationCode,
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}

}