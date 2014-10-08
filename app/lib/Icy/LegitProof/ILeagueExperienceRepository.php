<?php namespace Icy\LegitProof;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 6:28 PM
 */

interface ILeagueExperienceRepository {

	/**
	 * @param string $steamId
	 * @return LeagueExperience[]
	 */
	public function getAllBySteamId($steamId);

	/**
	 * @param array $values
	 * @return LeagueExperience
	 */
	public function create(array $values);

	/**
	 * @param LeagueExperience $leagueExperience
	 * @return bool
	 */
	public function save(LeagueExperience $leagueExperience);

} 