<?php namespace Kosiec\Service\Steam;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 2:00 AM
 */

class SteamService {

	/**
	 * @var ISteamWebApi
	 */
	private $api;

	public function __construct(ISteamWebApi $api)
	{
		$this->api = $api;
	}

	/**
	 * @param $vanityName
	 * @return int
	 * @throws SteamException
	 */
	public function resolveVanityUrl($vanityName)
	{
		$response = $this->api->resolveVanityUrl($vanityName);

		if ((int)$response->success !== 1 || !isset($response->steamid))
			throw new SteamException('Unable to resolve vanity name: ' . $response->message ?: 'Reason not specified');

		return (int)$response->steamid;
	}

}