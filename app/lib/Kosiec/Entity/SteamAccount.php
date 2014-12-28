<?php namespace Kosiec\Entity;
use Doctrine\ORM\Mapping AS ORM;
use Kosiec\ValueObject\SteamId;

/**
 * @ORM\Entity
 */
class SteamAccount extends AbstractEntity {

	const COMMUNITY_PRIVATE = 1;
	const COMMUNITY_PUBLIC = 3;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="bigint")
	 * @var SteamId
	 */
	private $steamId;

	// vac information
	/**
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $communityBanned;
	/**
	 * @ORM\Column(type="boolean")
	 * @var bool
	 */
	private $vacBanned;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $numberOfVacBans;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $daysSinceLastBan;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $economyBan;

	// player profile
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $communityVisibilityState;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $profileState;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $alias;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $lastLogOff;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $profileUrl;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $avatarUrl;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $mediumAvatarUrl;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $fullAvatarUrl;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $personaState;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $realName;
	/**
	 * @ORM\Column(type="bigint")
	 * @var int
	 */
	private $primaryClanId;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $timeCreated;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $personaStateFlags;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $locationCountryCode;
	/**
	 * @ORM\Column(type="string")
	 * @var string
	 */
	private $locationStateCode;
	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $locationCityId;

	public function __construct(SteamId $steamId)
	{
		$this->steamId = $steamId;
	}

	public function getSteamId()
	{
		return $this->convertAndReturnValueObject($this->steamId, function ($s)
		{
			return new SteamId($s);
		});
	}

	/**
	 * @param boolean $communityBanned
	 */
	public function setCommunityBanned($communityBanned)
	{
		$this->communityBanned = $communityBanned;
	}

	/**
	 * @param boolean $vacBanned
	 */
	public function setVacBanned($vacBanned)
	{
		$this->vacBanned = $vacBanned;
	}

	/**
	 * @param int $numberOfVacBans
	 */
	public function setNumberOfVacBans($numberOfVacBans)
	{
		$this->numberOfVacBans = $numberOfVacBans;
	}

	/**
	 * @param int $daysSinceLastBan
	 */
	public function setDaysSinceLastBan($daysSinceLastBan)
	{
		$this->daysSinceLastBan = $daysSinceLastBan;
	}

	/**
	 * @param string $economyBan
	 */
	public function setEconomyBan($economyBan)
	{
		$this->economyBan = $economyBan;
	}

	/**
	 * @param int $communityVisibilityState
	 */
	public function setCommunityVisibilityState($communityVisibilityState)
	{
		$this->communityVisibilityState = $communityVisibilityState;
	}

	/**
	 * @param int $profileState
	 */
	public function setProfileState($profileState)
	{
		$this->profileState = $profileState;
	}

	/**
	 * @param string $alias
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
	}

	/**
	 * @param int $lastLogOff
	 */
	public function setLastLogOff($lastLogOff)
	{
		$this->lastLogOff = $lastLogOff;
	}

	/**
	 * @param string $profileUrl
	 */
	public function setProfileUrl($profileUrl)
	{
		$this->profileUrl = $profileUrl;
	}

	/**
	 * @param string $avatarUrl
	 */
	public function setAvatarUrl($avatarUrl)
	{
		$this->avatarUrl = $avatarUrl;
	}

	/**
	 * @param string $mediumAvatarUrl
	 */
	public function setMediumAvatarUrl($mediumAvatarUrl)
	{
		$this->mediumAvatarUrl = $mediumAvatarUrl;
	}

	/**
	 * @param string $fullAvatarUrl
	 */
	public function setFullAvatarUrl($fullAvatarUrl)
	{
		$this->fullAvatarUrl = $fullAvatarUrl;
	}

	/**
	 * @param int $personaState
	 */
	public function setPersonaState($personaState)
	{
		$this->personaState = $personaState;
	}

	/**
	 * @param string $realName
	 */
	public function setRealName($realName)
	{
		$this->realName = $realName;
	}

	/**
	 * @param int $primaryClanId
	 */
	public function setPrimaryClanId($primaryClanId)
	{
		$this->primaryClanId = $primaryClanId;
	}

	/**
	 * @param int $timeCreated
	 */
	public function setTimeCreated($timeCreated)
	{
		$this->timeCreated = $timeCreated;
	}

	/**
	 * @param int $personaStateFlags
	 */
	public function setPersonaStateFlags($personaStateFlags)
	{
		$this->personaStateFlags = $personaStateFlags;
	}

	/**
	 * @param string $locationCountryCode
	 */
	public function setLocationCountryCode($locationCountryCode)
	{
		$this->locationCountryCode = $locationCountryCode;
	}

	/**
	 * @param string $locationStateCode
	 */
	public function setLocationStateCode($locationStateCode)
	{
		$this->locationStateCode = $locationStateCode;
	}

	/**
	 * @param int $locationCityId
	 */
	public function setLocationCityId($locationCityId)
	{
		$this->locationCityId = $locationCityId;
	}



}