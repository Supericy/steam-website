<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 10:35 AM
 */

class SteamService implements ISteamService {

	private $api;
	private $communityUrl;

	public function __construct(SteamWebAPI $api, $config)
	{
		$this->api = $api;

		$this->communityUrl = $config['community_url'];
	}

	public function communityUrl($steamId)
	{
		if (!$this->is64Id($steamId))
			throw new SteamException('Community URLs require a 64bit steam ID.');

		return $this->communityUrl . $steamId;
	}

	// $steamId = array or string of 64bit steamid
	public function isVacBanned($steamId)
	{
//		\Log::info('isVacBanned call', $steamId);

		$response = $this->api->getPlayerBans($steamId);

		$results = false;

		if ($response !== false)
		{
			$results = [];

//			dd($steamId);

			foreach ($response->players as $player)
			{
				$results[$player->SteamId] = $player->VACBanned;
			}

//			dd((int)$steamId);

			if (!is_array($steamId))
				$results = $results[(int) $steamId];
		}

		return $results;
	}

	public function resolveId($potentialId)
	{
		$steamId = false;

		$potentialId = rtrim($potentialId, '/');

		// only care about the last element if the potential id is a URL
		if (($pos = strrpos($potentialId, '/')) !== false)
		{
			$potentialId = substr($potentialId, $pos + 1);
		}

		// check to match 64-bit id (ie. '76561197960327544')
		if ($this->is64Id($potentialId))
		{
			$steamId = $potentialId;
		}
		else if ($this->isTextId($potentialId))
		{
			$steamId = $this->convertTextTo64($potentialId);
		}
		else
		{
			// id might be a vanity url, so let's attempt to resolve it.

			$response = $this->api->resolveVanityUrl($potentialId);

			if ($response !== false)
			{
				$response = $response->response;

				if ($response->success === 1)
				{
					$steamId = $response->steamid;
				}
			}
		}

		return $steamId;
	}

	// documentation: https://developer.valvesoftware.com/wiki/SteamID
	// converts a $textId in the format STEAM_X:X:XXXXXX to a 64bit community id (ie '76561197960327544')
	public function convertTextTo64($textId)
	{
		// strip off 'STEAM_'
		if (($pos = strpos($textId, 'STEAM_')) === 0)
		{
			$textId = substr($textId, $pos + 1);
		}

		// starting value
		$V = 0x0110000100000000;

		list(, $Y, $Z) = explode(':', $textId);

		return ($Z*2) + $V + $Y;
	}

	public function isTextId($steamId)
	{
		return preg_match('/(STEAM_)?[0-1]:[0-1]:\d{1,12}/', $steamId);
	}

	public function is64Id($steamId)
	{
		return preg_match('/\d{17}/', $steamId);
	}

}