<?php
use Carbon\Carbon;

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

		// TODO: seed a few steamids
		DB::table('steamids')->insert([
			$this->createRecordArray(76561197960327544, true, 3000, 1)
		]);
	}

	/**
	 * @param $steamId
	 * @param $vacBanned
	 * @param $daysSinceLastBan
	 * @param $legitProofed
	 * @return array
	 */
	private function createRecordArray($steamId, $vacBanned, $daysSinceLastBan, $legitProofed)
	{
		return [
			'steamid' => $steamId,
			'vac_banned' => $vacBanned,
			'days_since_last_ban' => $daysSinceLastBan,
			'legitproofed' => $legitProofed,
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}

}