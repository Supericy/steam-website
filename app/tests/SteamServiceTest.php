<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/3/2014
 * Time: 7:07 PM
 */

/**
 * Class SteamServiceTest
 * @group SteamService
 */
class SteamServiceTest extends TestCase {

	public function testGetVacBanStatusForMultiplePlayers()
	{
		/** @var Icy\Steam\ISteamService $steam */
		$steam = $this->app->make('Icy\Steam\ISteamService');

		$players = [
			(object)["SteamId" => "111"],
			(object)["SteamId" => "222"],
			(object)["SteamId" => "333"],
			(object)["SteamId" => "444"],
			(object)["SteamId" => "555"],
		];

		$method = new ReflectionMethod(
			'Icy\Steam\SteamService', 'createPlayerAssocArray'
		);
		$method->setAccessible(TRUE);

		$result = $method->invoke($steam, $players, 'SteamId', function ($steamId, $player) {
			return (object)['steamid' => $player->SteamId];
		});

		$expected = [
			"111" => (object)["steamid" => "111"],
			"222" => (object)["steamid" => "222"],
			"333" => (object)["steamid" => "333"],
			"444" => (object)["steamid" => "444"],
			"555" => (object)["steamid" => "555"],
		];

		$this->assertEquals($expected, $result);
	}

	public function testGetVacBanStatusForSinglePlayer()
	{
		/** @var Icy\Steam\ISteamService $steam */
		$steam = $this->app->make('Icy\Steam\ISteamService');

		// webapi call has more data, but we aren't worried about that
		$players = [
			(object)["SteamId" => "76561197960327544"]
		];

		$method = new ReflectionMethod(
			'Icy\Steam\SteamService', 'createPlayerAssocArray'
		);
		$method->setAccessible(TRUE);

		$result = $method->invoke($steam, $players, 'SteamId', function ($steamId, $player) {
			return (object)['steamid' => $player->SteamId];
		});

		$expected = (object)["steamid" => "76561197960327544"];

		$this->assertEquals($expected, $result);
	}

	public function testConvert64ToText()
	{
		/** @var Icy\Steam\ISteamService $steam */
		$steam = $this->app->make('Icy\Steam\ISteamService');

		$this->assertEquals('0:0:30908', $steam->convert64ToText('76561197960327544'));
		$this->assertEquals('STEAM_0:0:30908', $steam->convert64ToText('76561197960327544', true));
		$this->assertEquals('0:0:30908', $steam->convert64ToText(76561197960327544));
		$this->assertEquals('STEAM_0:0:30908', $steam->convert64ToText(76561197960327544, true));

		$this->assertEquals('0:1:17780000', $steam->convert64ToText('76561197995825729'));
		$this->assertEquals('STEAM_0:1:17780000', $steam->convert64ToText('76561197995825729', true));
		$this->assertEquals('0:1:17780000', $steam->convert64ToText(76561197995825729));
		$this->assertEquals('STEAM_0:1:17780000', $steam->convert64ToText(76561197995825729, true));

		$this->assertEquals('0:1:15029002', $steam->convert64ToText('76561197990323733'));
		$this->assertEquals('STEAM_0:1:15029002', $steam->convert64ToText('76561197990323733', true));
		$this->assertEquals('0:1:15029002', $steam->convert64ToText(76561197990323733));
		$this->assertEquals('STEAM_0:1:15029002', $steam->convert64ToText(76561197990323733, true));
	}

	public function testConvertTextTo64()
	{
		/** @var Icy\Steam\ISteamService $steam */
		$steam = $this->app->make('Icy\Steam\ISteamService');

		$steamId64 = '76561197960327544';

		$this->assertEquals($steamId64, $steam->convertTextTo64('0:0:30908'));
		$this->assertEquals($steamId64, $steam->convertTextTo64('STEAM_0:0:30908'));

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('76561197960327544');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('f42f4f4f24f24f');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64(':0:30908');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('00:0:30908');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('0::30908');
		}, 'Icy\Steam\SteamException');

		$this->assertException(function () use ($steam) {
			$steam->convertTextTo64('0:0:');
		}, 'Icy\Steam\SteamException');
	}

} 