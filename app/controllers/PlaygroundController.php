<?php

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/29/14
 * Time: 3:10 PM
 */
class PlaygroundController extends Controller {

	const CLASS_NAME = 'PlaygroundController';

	public function getIndex()
	{
		$urls = $this->getUrls();

		return View::make('tests.list-methods')->withUrls($urls);
	}

	public function getSteamCondenserTest()
	{
//		dd(app_path());

//		require_once(app_path() . '/../vendor/koraktor/steam-condenser/lib/steam/servers/SourceServer.php');

		$server = new SourceServer('23.19.172.139:27015');

		dd([
			'info' => $server->getServerInfo(),
			'ping' => $server->getPing(),
			'players' => $server->getPlayers(),
//			'rules' => $server->getRules(),
		]);
	}

	public function getSteamIdDisplayTest()
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
			'isFollowing' => true,
			'timesChecked' => 144,
			'hasBans', true,
			'bans' => $bans,
			'steamId64' => $steamId,
			'steamIdText' => $steamIdText,
			'hasLeagueExperience' => count($leagueExperiences) > 0,
			'leagueExperiences' => $leagueExperiences,
			'communityUrl' => 'http://steamcommunity.com/profiles/' . 76561197960327544,
		];

		Debugbar::info($data);

		return View::make('steamid.display')->with($data);
	}

	public function getAlertTest()
	{
		Session::forget('alerts.success');

		FlashHelper::append('alerts.success', 'This is just a test success alert.');
		FlashHelper::append('alerts.info', 'This is just a test info alert.');
		FlashHelper::append('alerts.warning', 'This is just a test warning alert.');
		FlashHelper::append('alerts.danger', 'This is just a test danger alert.');

		return View::make('master');
	}

	private function getUrls()
	{
		$urls = [];

		$class = new ReflectionClass('PlaygroundController');

		foreach ($class->getMethods() as $method)
		{
			if ($method->isPublic() && $method->getDeclaringClass()->getName() === self::CLASS_NAME)
			{
				$action = self::CLASS_NAME . '@' . $method->getName();

				$urls[] = URL::action($action);
			}
		}

		return $urls;
	}

}