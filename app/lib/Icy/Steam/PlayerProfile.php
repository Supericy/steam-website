<?php namespace Icy\Steam;

class PlayerProfile implements IPlayerProfile {

	private $steamId;
	private $communityVisibilityState;
	private $profileState;
	private $alias;
	private $lastLogOff;
	private $profileUrl;
	private $avatarUrl;
	private $mediumAvatarUrl;
	private $fullAvatarUrl;
	private $personaState;
	private $realName;
	private $primaryClanId;
	private $timeCreated;
	private $personaStateFlags;

	public function getAlias()
	{
		return $this->alias;
	}

	/**
	 * @param mixed $alias
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
	}

	public function getAvatarUrl()
	{
		return $this->avatarUrl;
	}

	/**
	 * @param mixed $avatarUrl
	 */
	public function setAvatarUrl($avatarUrl)
	{
		$this->avatarUrl = $avatarUrl;
	}

	public function getCommunityVisibilityState()
	{
		return $this->communityVisibilityState;
	}

	/**
	 * @param mixed $communityVisibilityState
	 */
	public function setCommunityVisibilityState($communityVisibilityState)
	{
		$this->communityVisibilityState = $communityVisibilityState;
	}

	public function getFullAvatarUrl()
	{
		return $this->fullAvatarUrl;
	}

	/**
	 * @param mixed $fullAvatarUrl
	 */
	public function setFullAvatarUrl($fullAvatarUrl)
	{
		$this->fullAvatarUrl = $fullAvatarUrl;
	}

	public function getLastLogOff()
	{
		return $this->lastLogOff;
	}

	/**
	 * @param mixed $lastLogOff
	 */
	public function setLastLogOff($lastLogOff)
	{
		$this->lastLogOff = $lastLogOff;
	}

	public function getMediumAvatarUrl()
	{
		return $this->mediumAvatarUrl;
	}

	/**
	 * @param mixed $mediumAvatarUrl
	 */
	public function setMediumAvatarUrl($mediumAvatarUrl)
	{
		$this->mediumAvatarUrl = $mediumAvatarUrl;
	}

	public function getPersonaState()
	{
		return $this->personaState;
	}

	/**
	 * @param mixed $personaState
	 */
	public function setPersonaState($personaState)
	{
		$this->personaState = $personaState;
	}

	public function getPersonaStateFlags()
	{
		return $this->personaStateFlags;
	}

	/**
	 * @param mixed $personaStateFlags
	 */
	public function setPersonaStateFlags($personaStateFlags)
	{
		$this->personaStateFlags = $personaStateFlags;
	}

	public function getPrimaryClanId()
	{
		return $this->primaryClanId;
	}

	/**
	 * @param mixed $primaryClanId
	 */
	public function setPrimaryClanId($primaryClanId)
	{
		$this->primaryClanId = $primaryClanId;
	}

	public function getProfileState()
	{
		return $this->profileState;
	}

	/**
	 * @param mixed $profileState
	 */
	public function setProfileState($profileState)
	{
		$this->profileState = $profileState;
	}

	public function getProfileUrl()
	{
		return $this->profileUrl;
	}

	/**
	 * @param mixed $profileUrl
	 */
	public function setProfileUrl($profileUrl)
	{
		$this->profileUrl = $profileUrl;
	}

	public function getRealName()
	{
		return $this->realName;
	}

	/**
	 * @param mixed $realName
	 */
	public function setRealName($realName)
	{
		$this->realName = $realName;
	}

	public function getSteamId()
	{
		return $this->steamId;
	}

	/**
	 * @param mixed $steamId
	 */
	public function setSteamId($steamId)
	{
		$this->steamId = $steamId;
	}

	public function getTimeCreated()
	{
		return $this->timeCreated;
	}

	/**
	 * @param mixed $timeCreated
	 */
	public function setTimeCreated($timeCreated)
	{
		$this->timeCreated = $timeCreated;
	}

}