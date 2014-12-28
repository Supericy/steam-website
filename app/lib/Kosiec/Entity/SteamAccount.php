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

	// --------------------------- vac information -----------------------
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 * @var bool
	 */
	private $communityBanned;
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 * @var bool
	 */
	private $vacBanned;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $numberOfVacBans;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $daysSinceLastBan;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $economyBan;
	// --------------------------- end vac information -----------------------


	// --------------------------- player profile ---------------------------
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $communityVisibilityState;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $profileState;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $alias;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $lastLogOff;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $profileUrl;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $avatarUrl;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $mediumAvatarUrl;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $fullAvatarUrl;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $personaState;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $realName;
	/**
	 * @ORM\Column(type="bigint", nullable=true)
	 * @var int
	 */
	private $primaryClanId;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $timeCreated;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $personaStateFlags;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $locationCountryCode;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @var string
	 */
	private $locationStateCode;
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $locationCityId;
	// --------------------------- end player profile ---------------------------

	function __construct(SteamId $steamId)
	{
		$this->steamId = $steamId;
		$this->communityBanned = null;
		$this->vacBanned = null;
		$this->numberOfVacBans = null;
		$this->daysSinceLastBan = null;
		$this->economyBan = null;
		$this->communityVisibilityState = null;
		$this->profileState = null;
		$this->alias = null;
		$this->lastLogOff = null;
		$this->profileUrl = null;
		$this->avatarUrl = null;
		$this->mediumAvatarUrl = null;
		$this->fullAvatarUrl = null;
		$this->personaState = null;
		$this->realName = null;
		$this->primaryClanId = null;
		$this->timeCreated = null;
		$this->personaStateFlags = null;
		$this->locationCountryCode = null;
		$this->locationStateCode = null;
		$this->locationCityId = null;
	}

	/**
	 * @return SteamId
	 */
	public function getSteamId()
	{
		return $this->convertAndReturnValueObject($this->steamId, function ($s)
		{
			return new SteamId($s);
		});
	}

	/**
	 * @return boolean
	 */
	public function isCommunityBanned()
	{
		return $this->communityBanned;
	}

	/**
	 * @param boolean $communityBanned
	 */
	public function setCommunityBanned($communityBanned)
	{
		$this->communityBanned = $communityBanned;
	}

	/**
	 * @return boolean
	 */
	public function isVacBanned()
	{
		return $this->vacBanned;
	}

	/**
	 * @param boolean $vacBanned
	 */
	public function setVacBanned($vacBanned)
	{
		$this->vacBanned = $vacBanned;
	}

	/**
	 * @return int
	 */
	public function getNumberOfVacBans()
	{
		return $this->numberOfVacBans;
	}

	/**
	 * @param int $numberOfVacBans
	 */
	public function setNumberOfVacBans($numberOfVacBans)
	{
		$this->numberOfVacBans = $numberOfVacBans;
	}

	/**
	 * @return int
	 */
	public function getDaysSinceLastBan()
	{
		return $this->daysSinceLastBan;
	}

	/**
	 * @param int $daysSinceLastBan
	 */
	public function setDaysSinceLastBan($daysSinceLastBan)
	{
		$this->daysSinceLastBan = $daysSinceLastBan;
	}

	/**
	 * @return string
	 */
	public function getEconomyBan()
	{
		return $this->economyBan;
	}

	/**
	 * @return bool
	 */
	public function isEconomyBanned()
	{
		return $this->economyBan !== 'none';
	}

	/**
	 * @param string $economyBan
	 */
	public function setEconomyBan($economyBan)
	{
		$this->economyBan = $economyBan;
	}

	/**
	 * @return int
	 */
	public function getCommunityVisibilityState()
	{
		return $this->communityVisibilityState;
	}

	/**
	 * @param int $communityVisibilityState
	 */
	public function setCommunityVisibilityState($communityVisibilityState)
	{
		$this->communityVisibilityState = $communityVisibilityState;
	}

	/**
	 * @return int
	 */
	public function getProfileState()
	{
		return $this->profileState;
	}

	/**
	 * @param int $profileState
	 */
	public function setProfileState($profileState)
	{
		$this->profileState = $profileState;
	}

	/**
	 * @return string
	 */
	public function getAlias()
	{
		return $this->alias;
	}

	/**
	 * @param string $alias
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
	}

	/**
	 * @return int
	 */
	public function getLastLogOff()
	{
		return $this->lastLogOff;
	}

	/**
	 * @param int $lastLogOff
	 */
	public function setLastLogOff($lastLogOff)
	{
		$this->lastLogOff = $lastLogOff;
	}

	/**
	 * @return string
	 */
	public function getProfileUrl()
	{
		return $this->profileUrl;
	}

	/**
	 * @param string $profileUrl
	 */
	public function setProfileUrl($profileUrl)
	{
		$this->profileUrl = $profileUrl;
	}

	/**
	 * @return string
	 */
	public function getAvatarUrl()
	{
		return $this->avatarUrl;
	}

	/**
	 * @param string $avatarUrl
	 */
	public function setAvatarUrl($avatarUrl)
	{
		$this->avatarUrl = $avatarUrl;
	}

	/**
	 * @return string
	 */
	public function getMediumAvatarUrl()
	{
		return $this->mediumAvatarUrl;
	}

	/**
	 * @param string $mediumAvatarUrl
	 */
	public function setMediumAvatarUrl($mediumAvatarUrl)
	{
		$this->mediumAvatarUrl = $mediumAvatarUrl;
	}

	/**
	 * @return string
	 */
	public function getFullAvatarUrl()
	{
		return $this->fullAvatarUrl;
	}

	/**
	 * @param string $fullAvatarUrl
	 */
	public function setFullAvatarUrl($fullAvatarUrl)
	{
		$this->fullAvatarUrl = $fullAvatarUrl;
	}

	/**
	 * @return int
	 */
	public function getPersonaState()
	{
		return $this->personaState;
	}

	/**
	 * @param int $personaState
	 */
	public function setPersonaState($personaState)
	{
		$this->personaState = $personaState;
	}

	/**
	 * @return string
	 */
	public function getRealName()
	{
		return $this->realName;
	}

	/**
	 * @param string $realName
	 */
	public function setRealName($realName)
	{
		$this->realName = $realName;
	}

	/**
	 * @return int
	 */
	public function getPrimaryClanId()
	{
		return $this->primaryClanId;
	}

	/**
	 * @param int $primaryClanId
	 */
	public function setPrimaryClanId($primaryClanId)
	{
		$this->primaryClanId = $primaryClanId;
	}

	/**
	 * @return int
	 */
	public function getTimeCreated()
	{
		return $this->timeCreated;
	}

	/**
	 * @param int $timeCreated
	 */
	public function setTimeCreated($timeCreated)
	{
		$this->timeCreated = $timeCreated;
	}

	/**
	 * @return int
	 */
	public function getPersonaStateFlags()
	{
		return $this->personaStateFlags;
	}

	/**
	 * @param int $personaStateFlags
	 */
	public function setPersonaStateFlags($personaStateFlags)
	{
		$this->personaStateFlags = $personaStateFlags;
	}

	/**
	 * @return string
	 */
	public function getLocationCountryCode()
	{
		return $this->locationCountryCode;
	}

	/**
	 * @param string $locationCountryCode
	 */
	public function setLocationCountryCode($locationCountryCode)
	{
		$this->locationCountryCode = $locationCountryCode;
	}

	/**
	 * @return string
	 */
	public function getLocationStateCode()
	{
		return $this->locationStateCode;
	}

	/**
	 * @param string $locationStateCode
	 */
	public function setLocationStateCode($locationStateCode)
	{
		$this->locationStateCode = $locationStateCode;
	}

	/**
	 * @return int
	 */
	public function getLocationCityId()
	{
		return $this->locationCityId;
	}

	/**
	 * @param int $locationCityId
	 */
	public function setLocationCityId($locationCityId)
	{
		$this->locationCityId = $locationCityId;
	}



}