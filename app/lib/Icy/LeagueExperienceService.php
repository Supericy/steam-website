<?php namespace Icy;

class LeagueExperienceService implements ILeagueExperienceService {

	private $legitProof;
	private $steam;
	private $leagueExperienceRepository;
	private $steamIdRepository;

	public function __construct(LegitProof\ILegitProof $legitProof, Steam\ISteamService $steam, LegitProof\ILeagueExperienceRepository $leagueExperienceRepository, Steam\ISteamIdRepository $steamIdRepository)
	{
		$this->legitProof = $legitProof;
		$this->steam = $steam;
		$this->leagueExperienceRepository = $leagueExperienceRepository;
		$this->steamIdRepository = $steamIdRepository;
	}

	public function updateLeagueExperiences($steamId)
	{
		$steamIdText = $this->steam->convert64ToText($steamId);

		$lpLeagueExperiences = $this->legitProof->getLeagueExperience($steamIdText);

		$leagueExperiences = [];

		foreach ($lpLeagueExperiences as $exp)
		{
			// assert $steamId === $this->steam->convertTextTo64($exp->getGuid());

			$leagueExperiences[] = $this->leagueExperienceRepository->firstOrCreate([
				'steamid' => $steamId,
				'guid' => $exp->getGuid(),
				'player' => $exp->getPlayer(),
				'team' => $exp->getTeam(),
				'league' => $exp->getLeague(),
				'division' => $exp->getDivision(),
				'join' => $this->createTimestampFromDate($exp->getJoin()),
				'leave' => $this->createTimestampFromDate($exp->getLeave())
			]);
		}

		return $leagueExperiences;
	}

	public function getLeagueExperiences($steamId, $forceUpdate = false)
	{
		$results = [];

		if ($forceUpdate)
		{
			$results = $this->updateLeagueExperiences($steamId);
		} else
		{
			$steamIdRecord = $this->getModel($steamId);

			if (!$steamIdRecord->isLegitProofed())
			{
				/*
				 * Update our league experience and then set our steamid as updated
				 */
				$results = $this->updateLeagueExperiences($steamId);

				$steamIdRecord->setLegitProofed(true);
				$this->steamIdRepository->save($steamIdRecord);
			} else
			{
				$results = $this->leagueExperienceRepository->getAllBySteamId($steamId);
			}
		}

		return $results;
	}

	/**
	 * @param string|Steam\SteamId $steamId
	 * @return Steam\SteamId
	 */
	private function getModel($steamId)
	{
		if ($steamId instanceof Steam\SteamId)
			return $steamId;
		else
			return $this->steamIdRepository->getBySteamId($steamId);
	}

	/**
	 * @param $date
	 * @return int|null
	 */
	private function createTimestampFromDate($date)
	{
		if ($date === LegitProof\LegitProofLeagueExperience::UNKNOWN_DATE)
			return null;

		$parsed = date_parse($date);

		$timestamp = mktime(
			$parsed['hour'],
			$parsed['minute'],
			$parsed['second'],
			$parsed['month'],
			$parsed['day'],
			$parsed['year']
		);

		return $timestamp;
	}

} 