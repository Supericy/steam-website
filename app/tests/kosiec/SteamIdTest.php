<?php
use Kosiec\ValueObject\SteamId;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 12:50 AM
 */

class SteamIdTest extends TestCase {

	public function test_CreateSteamIdWithCommunityId()
	{
		$steamId = new SteamId(76561197960327544);

		$this->assertSame(76561197960327544, $steamId->getCommunityId());
		$this->assertSame('STEAM_0:0:30908', $steamId->getSteamId());
	}

	public function test_CreateSteamIdWithSteamId()
	{
		$steamId = new SteamId('STEAM_0:0:30908');

		$this->assertSame(76561197960327544, $steamId->getCommunityId());
		$this->assertSame('STEAM_0:0:30908', $steamId->getSteamId());
	}

	public function test_CreateSteamIdWithMalformedSteamId()
	{
		$this->assertException(function ()
		{
			$steamId = new SteamId('malformed_id');
		}, '\InvalidArgumentException');
	}

}