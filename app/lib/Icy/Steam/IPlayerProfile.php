<?php namespace Icy\Steam;

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
	 * @return mixed
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
	 * @return mixed
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
	 * @return mixed
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