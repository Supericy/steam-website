<?php namespace Kosiec\Factory;
use InvalidArgumentException;
use Kosiec\Service\Steam\SteamService;
use Kosiec\ValueObject\SteamId;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/24/2014
 * Time: 12:00 AM
 */

class SteamIdFactory {

	/**
	 * @var SteamService
	 */
	private $steam;

	function __construct(SteamService $steam)
	{
		$this->steam = $steam;
	}

	/**
	 * @param $potentialId
	 * @return SteamId
	 * @throws InvalidArgumentException
	 */
	public function create($potentialId)
	{
		if ($potentialId === null || empty($potentialId))
			throw new InvalidArgumentException("Must not be null or empty");

		$potentialId = self::parseIdSectionIfUrl($potentialId);

		if (SteamId::isCommunityId($potentialId) || SteamId::isSteamId($potentialId))
		{
			return new SteamId($potentialId);
		}

		// not an id, so let's attempt to resolve via it's vanity url
		return $this->steam->resolveVanityUrl($potentialId);
	}

	private static function parseIdSectionIfUrl($potentialUrl)
	{
		$potentialUrl = rtrim($potentialUrl, '/');

		// only care about the last element if the potential id is a URL
		if (($pos = strrpos($potentialUrl, '/')) !== false)
		{
			$potentialUrl = substr($potentialUrl, $pos + 1);
		}

		if (($pos = strrpos($potentialUrl, '?')) !== false)
		{
			$potentialUrl = substr($potentialUrl, 0, $pos);
		}

		return $potentialUrl;
	}

}