<?php namespace Icy\Steam;
use Icy\Steam\Web\States\CommunityVisibilityState;
use Icy\Steam\Web\States\PersonaState;
use Icy\Steam\Web\States\ProfileState;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 2:10 AM
 */
interface IPlayerProfile {

	/**
	 * @return mixed
	 */
	public function getAlias();

	/**
	 * @return mixed
	 */
	public function getAvatarUrl();

	/**
	 * @return CommunityVisibilityState
	 */
	public function getCommunityVisibilityState();

	/**
	 * @return mixed
	 */
	public function getFullAvatarUrl();

	/**
	 * @return mixed
	 */
	public function getLastLogOff();

	/**
	 * @return mixed
	 */
	public function getMediumAvatarUrl();

	/**
	 * @return PersonaState
	 */
	public function getPersonaState();

	/**
	 * @return mixed
	 */
	public function getPersonaStateFlags();

	/**
	 * @return mixed
	 */
	public function getPrimaryClanId();

	/**
	 * @return ProfileState
	 */
	public function getProfileState();

	/**
	 * @return mixed
	 */
	public function getProfileUrl();

	/**
	 * @return mixed
	 */
	public function getRealName();

	/**
	 * @return mixed
	 */
	public function getSteamId();

	/**
	 * @return mixed
	 */
	public function getTimeCreated();

}