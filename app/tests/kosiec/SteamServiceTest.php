<?php
use Kosiec\Service\Steam\ISteamWebApi;
use Kosiec\Service\Steam\SteamService;
use Kosiec\ValueObject\SteamId;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 2:18 AM
 */

class SteamServiceTest extends TestCase {

	public function test_UpdateProfile()
	{
		$steamAccount = new \Kosiec\Entity\SteamAccount(new SteamId('0:0:30908'));
		$api = $this->getMockISteamWebApi($this->createSuccessfulResponse(76561197960327544));
		$steam = new \Kosiec\Service\Steam\SteamService($api);

	}

	public function test_ResolveVanityUrl_ValidVanityName()
	{
		$api = $this->getMockISteamWebApi($this->createSuccessfulResponse(76561197960327544));

		$steam = new SteamService($api);

		$this->assertSame(76561197960327544, $steam->resolveVanityUrl('supericy'));
	}

	public function test_ResolveVanityUrl_InvalidVanityName()
	{
		$api = $this->getMockISteamWebApi($this->createFailingResponse('No Match'));

		$steam = new SteamService($api);

		$this->assertException(function () use ($steam)
		{
			$steam->resolveVanityUrl('blahblah');
		}, '\Kosiec\Service\Steam\SteamException');
	}

	private function getMockHttpClient()
	{
		$response = $this->getMock('\GuzzleHttp\Message\ResponseInterface');
	}
	
	/**
	 * @param $resolveVanityUrlResponse
	 * @param $getPlayerSummariesResponse
	 * @param $getPlayerBansResponse
	 * @return ISteamWebApi
	 */
	private function getMockISteamWebApi($resolveVanityUrlResponse, $getPlayerSummariesResponse, $getPlayerBansResponse)
	{
		$api = $this->getMock('\Kosiec\Service\Steam\ISteamWebApi');
		$api->expects($this->any())
			->method('resolveVanityUrl')
			->willReturn($resolveVanityUrlResponse);

		$api->expects($this->any())
			->method('getPlayerSummaries')
			->willReturn($getPlayerSummariesResponse);

		$api->expects($this->any())
			->method('getPlayerBans')
			->willReturn($getPlayerBansResponse);

		return $api;
	}

	/**
	 * @param int $steamId
	 * @return mixed
	 */
	private function createSuccessfulResponse($steamId)
	{
		$json = '{
					"steamid": "' . $steamId . '",
					"success": 1
				}';

		return json_decode($json);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	private function createFailingResponse($message)
	{
		$json = '{
					"message": "' . $message . '",
					"success": 42
				}';

		return json_decode($json);
	}

}