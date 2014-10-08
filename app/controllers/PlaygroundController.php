<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/29/14
 * Time: 3:10 PM
 */

class PlaygroundController extends Controller {

	public function tests()
	{
		$steamId = 76561197960327544;
		$steamIdText = 'STEAM_0:0:30908';

		$bans = [
			new \Icy\Steam\VacBanStatus(true, 3600),
			new \Icy\Esea\EseaBanStatus(true, 'Supericy', 642643200),
		];

		$leagueExperiences = [];

		$data = [
			'steamId' => $steamId,
			'isFollowing' => false,
			'timesChecked' => 144,
			'hasBans' => count($bans) > 0,
			'bans' => $bans,
			'steamId64' => $steamId,
			'steamIdText' => $steamIdText,
			'leagueExperiences' => $leagueExperiences,
			'communityUrl' => 'http://steamcommunity.com/profiles/' . 76561197960327544,
		];

		Debugbar::info($data);

		return View::make('steamid.display')->with($data);
	}

}