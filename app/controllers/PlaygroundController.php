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

	public function getTestSteamIdDisplay()
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

	public function getTestAlert()
	{
		Session::forget('alerts.success');

		FlashHelper::append('alerts.success', 'This is just a test alert.');

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