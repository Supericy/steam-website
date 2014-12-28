<?php namespace Kosiec\Service\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 3:50 AM
 */

interface ISteamWebApi {

	/**
	 * @param $vanityName
	 * @return mixed
	 */
	public function resolveVanityUrl($vanityName);

	/**
	 * @param $steamIds
	 * @return mixed
	 */
	public function getPlayerBans($steamIds);

	/**
	 * @param $steamIds
	 * @return mixed
	 */
	public function getPlayerSummaries($steamIds);

	/**
	 * @return string
	 */
	public function getApiKey();

} 