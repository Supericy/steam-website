<?php
use Kosiec\Service\Steam\ISteamWebApi;
use Kosiec\Service\Steam\SteamService;
use Kosiec\Service\Steam\SteamWebApi;
use Kosiec\ValueObject\SteamId;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 2:18 AM
 */

class SteamServiceTest extends TestCase {

	/**
	 * @var \Kosiec\Service\Steam\SteamService
	 */
	private $steam;

	public function setUp()
	{
		parent::setUp();

		$getPlayerBansMap = [
			[76561197960327544,
				(object)[
					'players' => [
						(object)[
							'steamid' => '76561197960327544',
							'communitybanned' => true,
							'vacbanned' => true,
							'numberofvacbans' => 1,
							'dayssincelastban' => 3768,
							'economyban' => 'probation',
						]
					]
				]]
		];

		$getPlayerSummariesMap = [
			[76561197960327544,
				(object)[
					'players' => [
						(object)[
							'steamid' => '76561197960327544',
							'communityvisibilitystate' => 3,
							'profilestate' => 1,
							'personaname' => 'Supericy',
							'lastlogoff' => 1419404646,
							'profileurl' => 'http://steamcommunity.com/id/supericy/',
							'avatar' => 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg',
							'avatarmedium' => 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg',
							'avatarfull' => 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg',
							'personastate' => 1,
							'primaryclanid' => '103582791431363437',
							'timecreated' => 1063369658,
							'personastateflags' => 0
						]
					]
				]]
		];

		$resolveVanityUrlMap = [
			['supericy',
				(object)[
					'steamid' => '76561197960327544',
					'success' => 1
				]],

			['invalidname',
				(object)[
					'success' => 42,
					'message' => 'No Match'
				]]
		];

		/** @var PHPUnit_Framework_MockObject_MockObject|SteamWebApi $api */
		$api = $this->getMockBuilder('\Kosiec\Service\Steam\SteamWebApi')
			->disableOriginalConstructor()
			->getMock();
		$api->expects($this->any())
			->method('getPlayerBans')
			->will($this->returnValueMap($getPlayerBansMap));
		$api->expects($this->any())
			->method('getPlayerSummaries')
			->will($this->returnValueMap($getPlayerSummariesMap));
		$api->expects($this->any())
			->method('resolveVanityUrl')
			->will($this->returnValueMap($resolveVanityUrlMap));

		$this->steam = new SteamService($api);
	}

	public function test_UpdateAccountSummaries()
	{
		$steamAccount = new \Kosiec\Entity\SteamAccount(new SteamId(76561197960327544));

		$this->steam->updateAccountProfile($steamAccount);

		$this->assertEquals(3, $steamAccount->getCommunityVisibilityState());
		$this->assertEquals(1, $steamAccount->getProfileState());
		$this->assertEquals('Supericy', $steamAccount->getAlias());
		$this->assertEquals(1419404646, $steamAccount->getLastLogOff());
		$this->assertEquals("http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025.jpg", $steamAccount->getAvatarUrl());
		$this->assertEquals("http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_medium.jpg", $steamAccount->getMediumAvatarUrl());
		$this->assertEquals("http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c0/c0b62592da6bde522c256157b58d9fb786daf025_full.jpg", $steamAccount->getFullAvatarUrl());
		$this->assertEquals(1, $steamAccount->getPersonaState());
		$this->assertEquals(103582791431363437, $steamAccount->getPrimaryClanId());
		$this->assertEquals(1063369658, $steamAccount->getTimeCreated());
		$this->assertEquals(0, $steamAccount->getPersonaStateFlags());

	}

	public function test_UpdateAccountBans()
	{
		$steamAccount = new \Kosiec\Entity\SteamAccount(new SteamId(76561197960327544));

		$this->steam->updateAccountBans($steamAccount);

		$this->assertTrue($steamAccount->isVacBanned());
		$this->assertEquals(3768, $steamAccount->getDaysSinceLastBan());
		$this->assertEquals(1, $steamAccount->getNumberOfVacBans());
		$this->assertEquals('probation', $steamAccount->getEconomyBan());
		$this->assertTrue($steamAccount->isEconomyBanned());
	}

	public function test_ResolveVanityUrl_ValidVanityName()
	{
		$this->assertEquals(new SteamId(76561197960327544), $this->steam->resolveVanityUrl('supericy'));
	}

	public function test_ResolveVanityUrl_InvalidVanityName()
	{
		$this->assertException(function ()
		{
			$this->steam->resolveVanityUrl('invalidname');
		}, '\Kosiec\Service\Steam\SteamException');
	}

}