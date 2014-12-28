<?php
use GuzzleHttp\ClientInterface;
use Illuminate\Cache\Repository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/27/2014
 * Time: 1:53 AM
 */

class SteamWebApiTest extends TestCase {

	/**
	 * @var \Kosiec\Service\Steam\ISteamWebApi
	 */
	private $api;

	public function setUp()
	{
		parent::setUp();

		// client->get takes 2 params, second one will be an empty array
		$map = [
			['http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=api_key&vanityurl=supericy',
				[],
				$this->getMockResponse(200, '{
					"response": {
						"steamid": "76561197960327544",
						"success": 1
					}
				}')],

			['http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=api_key&vanityurl=bad_vanity_name',
				[],
				$this->getMockResponse(200, '{
					"response": {
						"success": 42,
						"message": "No match"
					}
				}')],

			['http://api.steampowered.com/ISteamUser/GetPlayerBans/v0001/?key=api_key&steamids=76561197960327544',
				[],
				$this->getMockResponse(200, '{
					"players": [
						{
							"SteamId": "76561197960327544",
							"CommunityBanned": false,
							"VACBanned": true,
							"NumberOfVACBans": 1,
							"DaysSinceLastBan": 3768,
							"EconomyBan": "none"
						}
					]
				}')],

			['http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=api_key&steamids=76561197960327544',
				[],
				$this->getMockResponse(200, '{
					"response": {
						"players": [
							{
								"steamid": "76561197960327544",
								"communityvisibilitystate": 3,
								"profilestate": 1,
								"personaname": "Supericy",
								"lastlogoff": 1419404646,
								"profileurl": "http://steamcommunity.com/id/supericy/",
								"avatar": "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg",
								"avatarmedium": "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg",
								"avatarfull": "http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg",
								"personastate": 1,
								"primaryclanid": "103582791431363437",
								"timecreated": 1063369658,
								"personastateflags": 0
							}
						]

					}
				}')],
		];

		/** @var PHPUnit_Framework_MockObject_MockObject|ClientInterface $client */
		$client = $this->getMock('\GuzzleHttp\ClientInterface');
		$client->expects($this->any())
			->method('get')
			->will($this->returnValueMap($map));

		$webApi = new \Kosiec\Service\Steam\SteamWebApi($client, new Repository(new \Illuminate\Cache\NullStore()), 'api_key');
		$this->assertInstanceOf('\Kosiec\Service\Steam\ISteamWebApi', $webApi);

		$this->api = $webApi;
	}

	public function test_GetPlayerSummaries_WithValidSteamId()
	{
		$response = $this->api->getPlayerSummaries(76561197960327544);

		$player = $response->players[0];

		$this->assertEquals(76561197960327544, $player->steamid);
		$this->assertEquals(3, $player->communityvisibilitystate);
		$this->assertEquals(1, $player->profilestate);
		$this->assertEquals('Supericy', $player->personaname);
		$this->assertEquals(1419404646, $player->lastlogoff);
		$this->assertEquals('http://steamcommunity.com/id/supericy/', $player->profileurl);
		$this->assertEquals('http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg', $player->avatar);
		$this->assertEquals('http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg', $player->avatarmedium);
		$this->assertEquals('http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg', $player->avatarfull);
		$this->assertEquals(1, $player->personastate);
		$this->assertEquals(103582791431363437, $player->primaryclanid);
		$this->assertEquals(1063369658, $player->timecreated);
		$this->assertEquals(0, $player->personastateflags);
	}

	public function test_GetPlayerBans_WithBannedSteamId()
	{
		$response = $this->api->getPlayerBans(76561197960327544);

		$player = $response->players[0];

		$this->assertEquals(76561197960327544, $player->steamid);
		$this->assertEquals(false, $player->communitybanned);
		$this->assertEquals(true, $player->vacbanned);
		$this->assertEquals(1, $player->numberofvacbans);
		$this->assertEquals(3768, $player->dayssincelastban);
		$this->assertEquals('none', $player->economyban);
	}

	public function test_ResolveVanityUrl_WithValidVanityName()
	{
		$response = $this->api->resolveVanityUrl('supericy');

		$this->assertSame(1, $response->success);
		$this->assertObjectHasAttribute('steamid', $response);
	}

	public function test_ResolveVanityUrl_WithInvalidVanityName()
	{
		$response = $this->api->resolveVanityUrl('bad_vanity_name');

		$this->assertNotEquals(1, $response->success);
		$this->assertObjectHasAttribute('message', $response);
	}

	/**
	 * @param $statusCode
	 * @param $jsonString
	 * @return \GuzzleHttp\Message\ResponseInterface
	 */
	private function getMockResponse($statusCode, $jsonString)
	{
		$response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
		$response->expects($this->any())
			->method('getStatusCode')
			->will($this->returnValue((string)$statusCode));
		$response->expects($this->any())
			->method('getBody')
			->will($this->returnValue($jsonString));
		$response->expects($this->any())
			->method('json')
			->will($this->returnValue(\json_decode($jsonString)));

		return $response;
	}


//	public function testGettingPlayerBansFromPlayerThatDoesNotExist()
//	{
//		$webApi = $this->getISteamWebApiInstance();
//
//		$response = $webApi->getPlayerBans(['76561888999999999']);
//
//		$expectedJsonData = '{"players":[]}';
//
//		$expected = \json_decode($expectedJsonData, false);
//	}
//
//	public function testSingleGetPlayerSummaries()
//	{
//		$webApi = $this->getISteamWebApiInstance();
//
//		$response = $webApi->getPlayerSummaries('76561197960327544');
//
//		$players = $response->players;
//
//		$this->assertEquals(1, count($players));
//
//		// the data we expect (rather than converting to php array manually, we'll assume json_decode works)
//		$expectedJsonData = '{
//								"steamid": "76561197960327544",
//								"communityvisibilitystate": 3,
//								"profilestate": 1,
//								"personaname": "Supericy",
//								"lastlogoff": 1413177666,
//								"profileurl": "http://steamcommunity.com/id/supericy/",
//								"avatar": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg",
//								"avatarmedium": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg",
//								"avatarfull": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg",
//								"personastate": 1,
//								"primaryclanid": "103582791431363437",
//								"timecreated": 1063369658,
//								"personastateflags": 0
//							}';
//		$expected = \json_decode($expectedJsonData, false);
//
//		// these are dynamic fields, we lets manually check they exist before updating our expect object
//		$this->assertObjectHasAttribute('communityvisibilitystate', $players[0]);
//		$this->assertObjectHasAttribute('lastlogoff', $players[0]);
//		$this->assertObjectHasAttribute('personastate', $players[0]);
//
//		// some of the data is expected to change, so we'll just update the fields.
//		$expected->communityvisibilitystate = $players[0]->communityvisibilitystate;
//		$expected->lastlogoff = $players[0]->lastlogoff;
//		$expected->personastate = $players[0]->personastate;
//
//		$this->assertEquals($expected, $players[0]);
//	}
//
//	public function testMultipleGetPlayerSummaries()
//	{
//		$webApi = $this->getISteamWebApiInstance();
//
//		$response = $webApi->getPlayerSummaries(['76561197960327544', '76561197960327544']);
//
//		$players = $response->players;
//
//		$this->assertEquals(2, count($players));
//
//		// the data we expect (rather than converting to php array manually, we'll assume json_decode works)
//		$expectedJsonData = '{
//								"steamid": "76561197960327544",
//								"communityvisibilitystate": 3,
//								"profilestate": 1,
//								"personaname": "Supericy",
//								"lastlogoff": 1413177666,
//								"profileurl": "http://steamcommunity.com/id/supericy/",
//								"avatar": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg",
//								"avatarmedium": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg",
//								"avatarfull": "http://media.steampowered.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg",
//								"personastate": 1,
//								"primaryclanid": "103582791431363437",
//								"timecreated": 1063369658,
//								"personastateflags": 0
//							}';
//
//		$expected = \json_decode($expectedJsonData, false);
//
//		// these are dynamic fields, we lets manually check they exist before updating our expect object
//		$this->assertObjectHasAttribute('communityvisibilitystate', $players[0]);
//		$this->assertObjectHasAttribute('lastlogoff', $players[0]);
//		$this->assertObjectHasAttribute('personastate', $players[0]);
//
//		// some of the data is expected to change, so we'll just update the fields.
//		$expected->communityvisibilitystate = $players[0]->communityvisibilitystate;
//		$expected->lastlogoff = $players[0]->lastlogoff;
//		$expected->personastate = $players[0]->personastate;
//		$expected->personastateflags = $players[0]->personastateflags;
//
//		$this->assertEquals([$expected, $expected], $players);
//
//		// is it nessesary to have the extra assertEquals if we've already asserted it above?
//		$this->assertEquals($expected, $players[0]);
//		$this->assertEquals($expected, $players[1]);
//	}
//
//	public function testSingleSteamIdGetPlayerBans()
//	{
//		$webApi = $this->getISteamWebApiInstance();
//
//		/*
//		 * TEST SINGLE STEAMID RESPONSE
//		 */
//		$response = $webApi->getPlayerBans('76561197960327544');
//
//		$players = $response->players;
//
//		// 1 steamid
//		$this->assertEquals(1, count($players));
//
//		// 1 steamid, 1 result
//		$player = $players[0];
//
//		$this->assertObjectHasAttribute('DaysSinceLastBan', $player);
//
//		$expected = (object)[
//			'SteamId' => '76561197960327544',
//			'CommunityBanned' => false,
//			'VACBanned' => true,
//			'NumberOfVACBans' => 1,
//			'DaysSinceLastBan' => $player->DaysSinceLastBan,
//			'EconomyBan' => 'none'
//		];
//
//		$this->assertEquals($expected, $player);
//	}
//
//	public function testMultipleSteamIdGetPlayerBans()
//	{
//		$webApi = $this->getISteamWebApiInstance();
//
//		/*
//		 * TEST MULTIPLE STEAMID RESPONSE
//		 */
//		// sending the same steamid twice will send twice the data back
//		$response = $webApi->getPlayerBans(['76561197960327544', '76561197960327544']);
//
//		$players = $response->players;
//
//		// 2 steamids
//		$this->assertEquals(2, count($players));
//
//		$this->assertObjectHasAttribute('DaysSinceLastBan', $players[0]);
//
//		$expected = (object)[
//			'SteamId' => '76561197960327544',
//			'CommunityBanned' => false,
//			'VACBanned' => true,
//			'NumberOfVACBans' => 1,
//			'DaysSinceLastBan' => $players[0]->DaysSinceLastBan,
//			'EconomyBan' => 'none'
//		];
//
//		$this->assertEquals([$expected, $expected], $players);
//
//		// is it nessesary to have the extra assertEquals if we've already asserted it above?
//		$this->assertEquals($expected, $players[0]);
//		$this->assertEquals($expected, $players[1]);
//	}

}