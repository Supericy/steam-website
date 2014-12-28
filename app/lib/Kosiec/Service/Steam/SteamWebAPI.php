<?php namespace Kosiec\Service\Steam;
use GuzzleHttp\ClientInterface;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/31/14
 * Time: 5:18 AM
 */

class SteamWebApi implements ISteamWebApi {

	// https://developer.valvesoftware.com/wiki/Steam_Web_API
	private $endpoints = [
		'ResolveVanityUrl' => [
			'url' => 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/',
			'cache' => 30],
		'GetPlayerBans' => [
			'url' => 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v0001/',
			'cache' => 30],
		'GetPlayerSummaries' => [
			'url' => 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/',
			'cache' => 30],
	];
	/**
	 * @var ClientInterface
	 */
	private $client;
	/**
	 * @var string
	 */
	private $apiKey;
	/**
	 * @var Repository
	 */
	private $cache;

	public function __construct(ClientInterface $client, CacheManager $cache, $apiKey)
	{
		$this->client = $client;
		$this->cache = $cache;
		$this->apiKey = $apiKey;
	}

	public function getApiKey()
	{
		return $this->apiKey;
	}

	public function getPlayerSummaries($steamIds)
	{
		// steam api lets us pass multiple steamids in query
		$steamIds = $this->implodeSteamIdsIfArray($steamIds);

		$response = $this->call('GetPlayerSummaries', [
			'steamids' => $steamIds
		]);

		// steamapi wraps response in response object
		return $response->response;
	}

	public function getPlayerBans($steamIds)
	{
		// steam api lets us pass multiple steamids in query
		$steamIds = $this->implodeSteamIdsIfArray($steamIds);

		return $this->call('GetPlayerBans', [
			'steamids' => $steamIds
		]);
	}

	public function resolveVanityUrl($vanityName)
	{
		$response = $this->call('ResolveVanityUrl', [
			'vanityurl' => $vanityName
		]);

		// steamapi wraps response in response object
		return $response->response;
	}

	private function implodeSteamIdsIfArray($steamIds)
	{
		if (is_array($steamIds))
			$steamIds = implode(',', $steamIds);

		return $steamIds;
	}

	private function call($endpointName, $params = [])
	{
		$endpoint = $this->endpoints[$endpointName];
		$url = $endpoint['url'] . '?' . http_build_query(array_merge(['key' => $this->apiKey], $params));

		$result = $this->cache->remember('steamapi_' . $url, $endpoint['cache'], function () use ($url)
		{
			$response = $this->client->get($url);

			if ((int)$response->getStatusCode() !== 200)
			{
				throw new SteamException($response->getBody());
			}

			return $response->json(['object' => true]);
		});

		return $result;
	}

}