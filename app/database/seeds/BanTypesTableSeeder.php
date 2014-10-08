<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 11:12 PM
 */

class BanTypesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('ban_types')->delete();

		DB::table('ban_types')->insert([
			['name' => 'VAC'],
			['name' => 'ESEA'],
		]);
	}

} 