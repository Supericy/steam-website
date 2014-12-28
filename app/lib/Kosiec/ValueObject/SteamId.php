<?php namespace Kosiec\ValueObject;
use InvalidArgumentException;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/23/2014
 * Time: 11:47 PM
 */

class SteamId {

	/**
	 * @var int
	 */
	private $communityId;

	/**
	 * @param string $potentialId
	 * @throws InvalidArgumentException
	 */
	function __construct($potentialId)
	{
		// convert to CommunityID if it's a SteamID
		if (self::isSteamId($potentialId))
			$potentialId = self::convertSteamToCommunityId($potentialId);

		// assert that it's a valid CommunityID
		if ( ! self::isCommunityId($potentialId))
			throw new InvalidArgumentException("Malformed SteamID/CommunityID: " . (string)$potentialId);

		$this->communityId = (int)$potentialId;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->string();
	}

	/**
	 * @return string
	 */
	public function string()
	{
		return $this->getSteamId();
	}

	/**
	 * @return string steamId in string format
	 * @throws InvalidArgumentException
	 */
	public function getSteamId()
	{
		return self::convertCommunityToSteamId($this->communityId, true);
	}

	/**
	 * @return int communityId 64bit integer
	 */
	public function getCommunityId()
	{
		return $this->communityId;
	}

	/**
	 * @param string $potentialId possible community id
	 * @return bool
	 */
	public static function isCommunityId($potentialId)
	{
		return !empty($potentialId) && preg_match('/^\d{17}$/', $potentialId);
	}

	/**
	 * @param string $potentialId possible steam id
	 * @return bool
	 */
	public static function isSteamId($potentialId)
	{
		return !empty($potentialId) && preg_match('/^(STEAM_)?[0-1]:[0-1]:\d{1,12}$/', $potentialId);
	}

	// documentation: https://developer.valvesoftware.com/wiki/SteamID
	// converts a $textId in the format STEAM_X:X:XXXXXX to a 64bit community id (ie '76561197960327544')
	private static function convertSteamToCommunityId($steamId)
	{
		if ( ! self::isSteamId($steamId))
			throw new InvalidArgumentException('Malformed SteamID: ' . $steamId);

		// strip off 'STEAM_'
		if (($pos = strpos($steamId, 'STEAM_')) === 0)
		{
			$steamId = substr($steamId, $pos + 1);
		}

		// starting value
		$V = 0x0110000100000000;

		list(, $Y, $Z) = explode(':', $steamId);

		return ($Z * 2) + $V + $Y;
	}

	// documentation: https://developer.valvesoftware.com/wiki/SteamID
	private static function convertCommunityToSteamId($communityId, $includePrefix = false)
	{
		if ( ! self::isCommunityId($communityId))
			throw new InvalidArgumentException('Malformed CommunityID: ' . $communityId);

		$W = (int)$communityId;
		$Y = $W & 1;
		$V = 0x0110000100000000;
		$Z = ($W - $Y - $V) / 2;

		return ($includePrefix ? 'STEAM_' : '') . '0:' . $Y . ':' . $Z;
	}
	
}