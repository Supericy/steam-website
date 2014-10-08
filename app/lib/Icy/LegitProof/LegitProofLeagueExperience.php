<?php namespace Icy\LegitProof;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 7:08 PM
 */

class LegitProofLeagueExperience {

	const UNKNOWN_DATE = '---';

	private $guid, $player, $team, $league, $division, $join, $leave;

	/**
	 * @return string
	 */
	public function getDivision()
	{
		return $this->division;
	}

	/**
	 * @param string $division
	 */
	public function setDivision($division)
	{
		$this->division = $division;
	}

	/**
	 * @return string
	 */
	public function getGuid()
	{
		return $this->guid;
	}

	/**
	 * @param string $guid
	 */
	public function setGuid($guid)
	{
		$this->guid = $guid;
	}

	/**
	 * @return string
	 */
	public function getJoin()
	{
		return $this->join;
	}

	/**
	 * @param string $join
	 */
	public function setJoin($join)
	{
		$this->join = $join;
	}

	/**
	 * @return string
	 */
	public function getLeague()
	{
		return $this->league;
	}

	/**
	 * @param string $league
	 */
	public function setLeague($league)
	{
		$this->league = $league;
	}

	/**
	 * @return string
	 */
	public function getLeave()
	{
		return $this->leave;
	}

	/**
	 * @param string $leave
	 */
	public function setLeave($leave)
	{
		$this->leave = $leave;
	}

	/**
	 * @return string
	 */
	public function getPlayer()
	{
		return $this->player;
	}

	/**
	 * @param string $player
	 */
	public function setPlayer($player)
	{
		$this->player = $player;
	}

	/**
	 * @return string
	 */
	public function getTeam()
	{
		return $this->team;
	}

	/**
	 * @param string $team
	 */
	public function setTeam($team)
	{
		$this->team = $team;
	}

	public function __toString()
	{
		return $this->getGuid() . ', ' . $this->getPlayer() . ', ' . $this->getLeague() . ', ' . $this->getDivision();
	}

}