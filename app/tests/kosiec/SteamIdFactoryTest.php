<?php
use Kosiec\Factory\SteamIdFactory;
use Kosiec\ValueObject\SteamId;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 1:26 AM
 */

class SteamIdFactoryTest extends TestCase {

	/**
	 * @var \Kosiec\Factory\SteamIdFactory
	 */
	private $factory;

	public function setUp()
	{
		parent::setUp();

		$steam = $this->getMockBuilder('\Kosiec\Service\Steam\SteamService')
			->disableOriginalConstructor()
			->getMock();
		$steam->expects($this->any())
				->method('resolveVanityUrl')
				->willReturn(new SteamId(76561197960327544));

		$this->factory = new SteamIdFactory($steam);
	}

	public function test_CreatingSteamId_FromCommunityId()
	{
		$steamId = $this->factory->create(76561197960327544);

		$this->assertExpectedSteamId($steamId);
	}

	public function test_CreatingSteamId_FromSteamId()
	{
		// without STEAM_ prefix
		$steamId = $this->factory->create('0:0:30908');
		$this->assertExpectedSteamId($steamId);

		$steamId = $this->factory->create('STEAM_0:0:30908');
		$this->assertExpectedSteamId($steamId);
	}

	public function test_CreatingSteamId_FromVanityName()
	{
		$steamId = $this->factory->create('supericy');
		$this->assertExpectedSteamId($steamId);
	}

	/**
	 * @param $steamId
	 */
	private function assertExpectedSteamId(SteamId $steamId)
	{
		$this->assertInstanceOf('Kosiec\ValueObject\SteamId', $steamId);
		$this->assertSame(76561197960327544, $steamId->to64bit());
		$this->assertSame('0:0:30908', $steamId->to32bit());
		$this->assertSame('STEAM_0:0:30908', $steamId->string());
	}

}