<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 4:07 AM
 */

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