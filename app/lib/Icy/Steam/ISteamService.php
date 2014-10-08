<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 11:16 AM
 */

interface ISteamService {

	/**
	 * @param $steamId
	 * @return VacBanStatus|VacBanStatus[]
	 */
	public function getVacBanStatus($steamId);

	/**
	 * @param $potentialId
	 * @return string|false
	 */
	public function resolveId($potentialId);

	/**
	 * @param $textId
	 * @return string
	 * @throws SteamException
	 */
	public function convertTextTo64($textId);

	/**
	 * @param $steamId
	 * @param bool $includePrefix
	 * 		Toggles whether to prepend STEAM_ to the ID or not before returning
	 * @return string
	 */
	public function convert64ToText($steamId, $includePrefix = false);

	/**
	 * @param $steamId
	 * @return string
	 * @throws SteamException
	 */
	public function getCommunityUrl($steamId);

	/**
	 * @param string $steamId
	 * @return bool
	 */
	public function isTextId($steamId);

	/**
	 * @param string $steamId
	 * @return bool
	 */
	public function is64Id($steamId);

}