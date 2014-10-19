<?php namespace Icy;
	/**
	 * Created by PhpStorm.
	 * User: Chad
	 * Date: 10/6/2014
	 * Time: 7:30 PM
	 */


/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 6:54 PM
 */
interface ILeagueExperienceManager {

	/**
	 * @param string $steamId
	 * @return LegitProof\LeagueExperience[]
	 */
	public function updateLeagueExperiences($steamId);

	/**
	 * @param string $steamId
	 * @param bool $updateRequired
	 * @return LegitProof\LeagueExperience[]
	 */
	public function getLeagueExperiences($steamId, $updateRequired = false);

}