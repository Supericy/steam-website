<?php namespace Icy\LegitProof;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 6:37 PM
 */

class LeagueExperienceRepository implements ILeagueExperienceRepository {

	private $model;

	public function __construct(LeagueExperience $model)
	{
		$this->model = $model;
	}

	public function getAllBySteamId($steamId)
	{
		return $this->model->where('steamid', $steamId)->get();
	}

	public function create(array $values)
	{
		return $this->model->create($values);
	}

	public function save(LeagueExperience $leagueExperience)
	{
		return $this->model->save($leagueExperience);
	}

} 