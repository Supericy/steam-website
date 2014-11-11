<?php namespace Icy\Steam\Web;
use GuzzleHttp\ClientInterface;
use Icy\Common\MeasurableTrait;
use Icy\Steam\SteamException;
use Illuminate\Cache\CacheManager;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/31/14
 * Time: 5:18 AM
 */

class SteamWebAPI implements ISteamWebAPI {

	use MeasurableTrait;

	private $client;
	private $apiKey;

	// https://developer.valvesoftware.com/wiki/Steam_Web_API
	private $endpoints = [
		'ResolveVanityUrl' => 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/',
		'GetPlayerBans' => 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v0001/',
		'GetPlayerSummaries' => 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/'
	];

	/**
	 * @var CacheManager
	 */
	private $cache;

	public function __construct(ClientInterface $client, CacheManager $cache)
	{
		$this->client = $client;
		$this->jsonResponseDecoding = true;
		$this->cache = $cache;
	}

	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function getApiKey()
	{
		return $this->apiKey;
	}

	public function getPlayerSummaries($steamIds)
	{
		// steam api lets us pass multiple steamids in query
		$steamIds = $this->createSteamIdsString($steamIds);

		$response = $this->call($this->endpoints['GetPlayerSummaries'], [
			'steamids' => $steamIds
		]);

		// steamapi wraps response in response object
		return $response->response;
	}

	public function getPlayerBans($steamIds)
	{
		// steam api lets us pass multiple steamids in query
		$steamIds = $this->createSteamIdsString($steamIds);

		return $this->call($this->endpoints['GetPlayerBans'], [
			'steamids' => $steamIds
		]);
	}

	public function resolveVanityUrl($vanityName)
	{
		return $this->call($this->endpoints['ResolveVanityUrl'], [
			'vanityurl' => $vanityName
		]);
	}

	private function createSteamIdsString($steamIds)
	{
		if (is_array($steamIds))
			$steamIds = implode(',', $steamIds);

		return $steamIds;
	}

	private function call($endpoint, $params = [])
	{
		$this->startMeasure('steam', 'SteamWebAPI');

		$url = $endpoint . '?' . http_build_query(array_merge(['key' => $this->apiKey], $params));

		$result = $this->cache->remember('steamapi_' . $url, 30, function () use ($url)
		{
			$response = $this->client->get($url);

			if ((int)$response->getStatusCode() !== 200)
			{
				throw new SteamException($response->getBody());
			}

			return $response->json(['object' => true]);
		});

		$this->stopMeasure('steam');

		return $result;
	}

}