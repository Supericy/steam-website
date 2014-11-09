<?php namespace Icy;

class LeagueExperienceService implements ILeagueExperienceService {

	private $legitProof;
	private $steam;
	private $leagueExperienceRepository;
	private $steamIdRepository;

	public function __construct(LegitProof\ILegitProofService $legitProof, Steam\ISteamService $steam, LegitProof\ILeagueExperienceRepository $leagueExperienceRepository, Steam\ISteamIdRepository $steamIdRepository)
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

		if ($lpLeagueExperiences === false)
			return false;

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
				'join' => $exp->getJoinTimestamp(),
				'leave' => $exp->getLeaveTimestamp()
			]);
		}

		return $leagueExperiences;
	}

	public function getLeagueExperiences($steamId, $forceUpdate = false)
	{
		return $this->leagueExperienceRepository->getAllBySteamId($steamId);
	}

//	public function getLeagueExperiences($steamId, $forceUpdate = false)
//	{
//		$results = [];
//
//		if ($forceUpdate)
//		{
//			$results = $this->updateLeagueExperiences($steamId);
//		} else
//		{
//			$steamIdRecord = $this->getModel($steamId);
//
//			if (!$steamIdRecord->isLegitProofed())
//			{
//				/*
//				 * Update our league experience and then set our steamid as updated
//				 *
//				 * This will return false if we couldn't connect to legit-proof
//				 */
//				$results = $this->updateLeagueExperiences($steamId);
//
//				if ($results !== false)
//				{
//					$steamIdRecord->setLegitProofed(true);
//					$this->steamIdRepository->save($steamIdRecord);
//				}
//
//				// we didn't get any results, so lets just return an empty array for now
//				if ($results === false)
//					$results = [];
//			} else
//			{
//				$results = $this->leagueExperienceRepository->getAllBySteamId($steamId);
//			}
//		}
//
//		return $results;
//	}

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



} 