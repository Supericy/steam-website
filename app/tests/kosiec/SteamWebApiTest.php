<?php
use Illuminate\Cache\Repository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/27/2014
 * Time: 1:53 AM
 */

class SteamWebApiTest extends TestCase {


	/**
	 * @return \Kosiec\Service\Steam\SteamService
	 */
	public function getISteamWebApiInstance()
	{
		$webApi = new \Kosiec\Service\Steam\SteamWebApi(new \GuzzleHttp\Client(), new Repository(new \Illuminate\Cache\NullStore()), null);
		$this->assertInstanceOf('\Kosiec\Service\Steam\ISteamWebApi', $webApi);

		return $webApi;
	}

	public function testGettingPlayerBansFromPlayerThatDoesNotExist()
	{
		$webApi = $this->getISteamWebApiInstance();

		$response = $webApi->getPlayerBans(['76561888999999999']);

		$expectedJsonData = '{"players":[]}';

		$expected = \json_decode($expectedJsonData, false);
	}

	public function testSingleGetPlayerSummaries()
	{
		$webApi = $this->getISteamWebApiInstance();

		$response = $webApi->getPlayerSummaries('76561197960327544');

		$players = $response->players;

		$this->assertEquals(1, count($players));

		// the data we expect (rather than converting to php array manually, we'll assume json_decode works)
		$expectedJsonData = '{
								"steamid": "76561197960327544",
								"communityvisibilitystate": 3,
								"profilestate": 1,
								"personaname": "Supericy",
								"lastlogoff": 1413177666,
								"profileurl": "http://steamcommunity.com/id/supericy/",
								"avatar": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg",
								"avatarmedium": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg",
								"avatarfull": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg",
								"personastate": 1,
								"primaryclanid": "103582791431363437",
								"timecreated": 1063369658,
								"personastateflags": 0
							}';

		$expected = \json_decode($expectedJsonData, false);

		// these are dynamic fields, we lets manually check they exist before updating our expect object
		$this->assertObjectHasAttribute('communityvisibilitystate', $players[0]);
		$this->assertObjectHasAttribute('lastlogoff', $players[0]);
		$this->assertObjectHasAttribute('personastate', $players[0]);

		// some of the data is expected to change, so we'll just update the fields.
		$expected->communityvisibilitystate = $players[0]->communityvisibilitystate;
		$expected->lastlogoff = $players[0]->lastlogoff;
		$expected->personastate = $players[0]->personastate;

		$this->assertEquals($expected, $players[0]);
	}

	public function testMultipleGetPlayerSummaries()
	{
		$webApi = $this->getISteamWebApiInstance();

		$response = $webApi->getPlayerSummaries(['76561197960327544', '76561197960327544']);

		$players = $response->players;

		$this->assertEquals(2, count($players));

		// the data we expect (rather than converting to php array manually, we'll assume json_decode works)
		$expectedJsonData = '{
								"steamid": "76561197960327544",
								"communityvisibilitystate": 3,
								"profilestate": 1,
								"personaname": "Supericy",
								"lastlogoff": 1413177666,
								"profileurl": "http://steamcommunity.com/id/supericy/",
								"avatar": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg",
								"avatarmedium": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg",
								"avatarfull": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg",
								"personastate": 1,
								"primaryclanid": "103582791431363437",
								"timecreated": 1063369658,
								"personastateflags": 0
							}';

		$expected = \json_decode($expectedJsonData, false);

		// these are dynamic fields, we lets manually check they exist before updating our expect object
		$this->assertObjectHasAttribute('communityvisibilitystate', $players[0]);
		$this->assertObjectHasAttribute('lastlogoff', $players[0]);
		$this->assertObjectHasAttribute('personastate', $players[0]);

		// some of the data is expected to change, so we'll just update the fields.
		$expected->communityvisibilitystate = $players[0]->communityvisibilitystate;
		$expected->lastlogoff = $players[0]->lastlogoff;
		$expected->personastate = $players[0]->personastate;
		$expected->personastateflags = $players[0]->personastateflags;

		$this->assertEquals([$expected, $expected], $players);

		// is it nessesary to have the extra assertEquals if we've already asserted it above?
		$this->assertEquals($expected, $players[0]);
		$this->assertEquals($expected, $players[1]);
	}

	public function testSingleSteamIdGetPlayerBans()
	{
		$webApi = $this->getISteamWebApiInstance();

		/*
		 * TEST SINGLE STEAMID RESPONSE
		 */
		$response = $webApi->getPlayerBans('76561197960327544');

		$players = $response->players;

		// 1 steamid
		$this->assertEquals(1, count($players));

		// 1 steamid, 1 result
		$player = $players[0];

		$this->assertObjectHasAttribute('DaysSinceLastBan', $player);

		$expected = (object)[
			'SteamId' => '76561197960327544',
			'CommunityBanned' => false,
			'VACBanned' => true,
			'NumberOfVACBans' => 1,
			'DaysSinceLastBan' => $player->DaysSinceLastBan,
			'EconomyBan' => 'none'
		];

		$this->assertEquals($expected, $player);
	}

	public function testMultipleSteamIdGetPlayerBans()
	{
		$webApi = $this->getISteamWebApiInstance();

		/*
		 * TEST MULTIPLE STEAMID RESPONSE
		 */
		// sending the same steamid twice will send twice the data back
		$response = $webApi->getPlayerBans(['76561197960327544', '76561197960327544']);

		$players = $response->players;

		// 2 steamids
		$this->assertEquals(2, count($players));

		$this->assertObjectHasAttribute('DaysSinceLastBan', $players[0]);

		$expected = (object)[
			'SteamId' => '76561197960327544',
			'CommunityBanned' => false,
			'VACBanned' => true,
			'NumberOfVACBans' => 1,
			'DaysSinceLastBan' => $players[0]->DaysSinceLastBan,
			'EconomyBan' => 'none'
		];

		$this->assertEquals([$expected, $expected], $players);

		// is it nessesary to have the extra assertEquals if we've already asserted it above?
		$this->assertEquals($expected, $players[0]);
		$this->assertEquals($expected, $players[1]);
	}

}