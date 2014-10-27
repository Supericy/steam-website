<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 3:17 AM
 */

class FavouriteTableSeeder extends Seeder {

	public function run()
	{
		DB::table('favourites')->delete();

		DB::table('favourites')->insert([
			$this->createRecordArray(1, 1)
		]);
	}

	public function createRecordArray($userId, $steamIdId)
	{
		return [
			'user_id' => $userId,
			'steamid_id' => $steamIdId,
		];
	}

} 