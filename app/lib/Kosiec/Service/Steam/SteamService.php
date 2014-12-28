<?php namespace Kosiec\Service\Steam;
use Kosiec\Entity\SteamAccount;
use Kosiec\ValueObject\SteamId;

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
	 * @return SteamId
	 * @throws SteamException
	 */
	public function resolveVanityUrl($vanityName)
	{
		$response = $this->api->resolveVanityUrl($vanityName);

		if ((int)$response->success !== 1 || ! isset($response->steamid))
			throw new SteamException('Unable to resolve vanity name: ' . $response->message ?: 'Reason not specified');

		return new SteamId($response->steamid);
	}

	/**
	 * @param SteamAccount $steamAccount
	 * @throws SteamException
	 */
	public function updateAccountBans(SteamAccount $steamAccount)
	{
		$response = $this->api->getPlayerBans($steamAccount->getSteamId()->to64bit());

		if (empty($response->players))
			throw new SteamException('Unable to get player bans for: ' . $steamAccount->getSteamId()->to64bit());

		$player = $response->players[0];

		$steamAccount->setCommunityBanned($player->communitybanned);
		$steamAccount->setVacBanned($player->vacbanned);
		$steamAccount->setNumberOfVacBans($player->numberofvacbans);
		$steamAccount->setDaysSinceLastBan($player->dayssincelastban);
		$steamAccount->setEconomyBan($player->economyban);
	}

	/**
	 * @param SteamAccount $steamAccount
	 * @throws SteamException
	 */
	public function updateAccountProfile(SteamAccount $steamAccount)
	{
		$response = $this->api->getPlayerSummaries($steamAccount->getSteamId()->to64bit());

		if (empty($response->players))
			throw new SteamException('Unable to get player profiles for: ' . $steamAccount->getSteamId()->to64bit());

		$player = $response->players[0];

		\Log::debug('player', ['player' => $player,
		]);

		$steamAccount->setCommunityVisibilityState($player->communityvisibilitystate);
		$steamAccount->setProfileState($player->profilestate);
		$steamAccount->setAlias($player->personaname);
		$steamAccount->setLastLogOff($player->lastlogoff);
		$steamAccount->setProfileUrl($player->profileurl);
		$steamAccount->setAvatarUrl($player->avatar);
		$steamAccount->setMediumAvatarUrl($player->avatarmedium);
		$steamAccount->setFullAvatarUrl($player->avatarfull);
		$steamAccount->setPersonaState($player->personastate);
		$steamAccount->setPrimaryClanId($player->primaryclanid);
		$steamAccount->setTimeCreated($player->timecreated);
		$steamAccount->setPersonaStateFlags($player->personastateflags);
	}

}