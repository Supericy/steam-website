<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/21/2014
 * Time: 4:06 AM
 */

class OAuthProviderTableSeeder extends Seeder {

	public function run()
	{
		DB::table('oauth_providers')->delete();

		DB::table('oauth_providers')->insert([
			['name' => 'Google'],
		]);
	}

}