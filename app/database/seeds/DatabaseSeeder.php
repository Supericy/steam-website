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

		$this->call('OAuthProviderTableSeeder');
		$this->call('BanTypesTableSeeder');

		$this->call('UserTableSeeder');
		$this->call('SteamIdTableSeeder');
		$this->call('FavouriteTableSeeder');
	}

}