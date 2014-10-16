<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 10:35 AM
 */

class SteamService implements ISteamService {

	private $api;
	private $baseCommunityUrl;

	public function __construct(Web\ISteamWebAPI $api)
	{
		$this->api = $api;
	}

	public function setBaseCommunityUrl($baseCommunityUrl)
	{
		$this->baseCommunityUrl = $baseCommunityUrl;
	}

	public function getBaseCommunityUrl()
	{
		return $this->baseCommunityUrl;
	}

	private function createPlayerAssocArray($players, $key, Callable $callback)
	{
		$count = count($players);

		if ($count == 0)
		{
			$results = false;
		}
		else if ($count == 1)
		{
			$results = $callback($players[0]->{$key}, $players[0]);
		}
		else if ($count > 1)
		{
			$results = [];

			foreach ($players as $player)
			{
				$results[$player->{$key}] = $callback($player->{$key}, $player);
			}
		}

		return $results;
	}

	public function getCommunityUrl($steamId)
	{
		if (!$this->is64Id($steamId))
			throw new SteamException('Community URLs require a 64bit steam ID.');

		return $this->baseCommunityUrl . $steamId;
	}

	// $steamId = array or string of 64bit steamid
	public function getVacBanStatus($steamId)
	{
//		\Log::info('isVacBanned call', $steamId);

		$response = $this->api->getPlayerBans($steamId);

		$results = false;

		if ($response !== false)
		{
			$results = $this->createPlayerAssocArray($response->players, 'SteamId', function ($steamId, $player){
				return new VacBanStatus($player->VACBanned, $player->VACBanned ? $player->DaysSinceLastBan : null);
			});
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
		if (!$this->isTextId($textId))
			throw new SteamException('Malformed text steamID. Must be in the format (STEAM_)X:X:XXXXX..X');

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

	// documentation: https://developer.valvesoftware.com/wiki/SteamID
	public function convert64ToText($steamId, $includePrefix = false)
	{
		if (!$this->is64Id($steamId))
			throw new SteamException('Malformed 64bit steamID. Must be in the format (XXXXXXXXXXXX..X).');

		$W = (int)$steamId;
		$Y = $W & 1;
		$V = 0x0110000100000000;
		$Z = ($W - $Y - $V) / 2;

		return ($includePrefix ? 'STEAM_' : '') . '0:' . $Y . ':' . $Z;
	}

	public function isTextId($steamId)
	{
		return preg_match('/^(STEAM_)?[0-1]:[0-1]:\d{1,12}$/', $steamId);
	}

	public function is64Id($steamId)
	{
		return preg_match('/^\d{17}$/', $steamId);
	}

	public function getPlayerProfile($steamId)
	{
		$response = $this->api->getPlayerSummaries($steamId);

		$results = false;

		if ($response !== false)
		{
			$results = $this->createPlayerAssocArray($response->players, 'steamid', function ($steamId, $player) {
				$profile = new PlayerProfile();
				$profile->setSteamId($player->steamid);
				$profile->setCommunityVisibilityState($player->communityvisibilitystate);
				$profile->setProfileState($player->profilestate);
				$profile->setAlias($player->personaname);
				$profile->setLastLogOff($player->lastlogoff);
				$profile->setProfileUrl($player->profileurl);
				$profile->setAvatarUrl($player->avatar);
				$profile->setMediumAvatarUrl($player->avatarmedium);
				$profile->setFullAvatarUrl($player->avatarfull);
				$profile->setPersonaState($player->personastate);
				$profile->setPrimaryClanId($player->primaryclanid);
				$profile->setTimeCreated($player->timecreated);
				$profile->setPersonaStateFlags($player->personastateflags);
				return $profile;
			});
		}

		return $results;
	}
}