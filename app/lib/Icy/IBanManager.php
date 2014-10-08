<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:30 PM
 */

interface IBanManager {

	/**
	 * @param string|Steam\SteamId $steamId
	 * @param null|Steam\VacBanStatus $newVacStatus
	 * @return Steam\SteamId
	 */
	public function fetchAndUpdate($steamId, Steam\VacBanStatus $newVacStatus = null);

}