<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		 $this->call('UserTableSeeder');
		 $this->call('SteamIdTableSeeder');
	}

}

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

class SteamIdTableSeeder extends Seeder {

    public function run()
    {
        DB::table('steamids')->delete();

        SteamId::create(array(
            'steamid' => '76561197960327544',
            'vac_status' => false,
        ));
    }

}