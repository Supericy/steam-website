<?php namespace Icy\Steam;
use SebastianBergmann\Exporter\Exception;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/31/14
 * Time: 5:18 AM
 */

class SteamWebAPI {

	private $apiKey;

	private $endpoints = [
		'ResolveVanityUrl' => 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/',
		'GetPlayerBans' => 'http://api.steampowered.com/ISteamUser/GetPlayerBans/v0001/',
	];

	public function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function getPlayerBans($steamIds)
	{
		// steam api lets us pass multiple steamids in query
		if (is_array($steamIds))
			$steamIds = implode(',', $steamIds);

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

	private function call($endpoint, $params = [])
	{
		$url = $endpoint . '?' . http_build_query(array_merge(['key' => $this->apiKey], $params));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		if (($erno = curl_error($ch)) > 0)
		{
			$reason = sprintf('An error (erno:%d) occured while trying to curl: %s', $erno, $endpoint);

			// more accurate error message
			if ($erno === CURLE_OPERATION_TIMEOUTED)
				$reason = 'Steam Web API Timed Out.';

			throw new Exception($reason);
		}
		if (curl_error($ch) === CURLE_OPERATION_TIMEOUTED)
		{
			throw new Exception('Steam API timed out.');
		}

		$jsonResponse = curl_exec($ch);

		$response = false;

		if ($jsonResponse !== false)
		{
			$response = json_decode($jsonResponse);
		}

		return $response;
	}

}