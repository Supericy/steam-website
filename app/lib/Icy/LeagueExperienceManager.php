<?php namespace Icy;

class LeagueExperienceManager implements ILeagueExperienceManager {

	private $legitProof;
	private $steam;
	private $leagueExperienceRepository;

	public function __construct(LegitProof\ILegitProof $legitProof, Steam\ISteamService $steam, LegitProof\ILeagueExperienceRepository $leagueExperienceRepository)
	{
		$this->legitProof = $legitProof;
		$this->steam = $steam;
		$this->leagueExperienceRepository = $leagueExperienceRepository;
	}

	public function updateLeagueExperiences($steamId)
	{
		$steamIdText = $this->steam->convert64ToText($steamId);

		$lpLeagueExperiences = $this->legitProof->getLeagueExperience($steamIdText);

		$leagueExperiences = [];

		foreach ($lpLeagueExperiences as $exp)
		{
			// assert $steamId === $this->steam->convertTextTo64($exp->getGuid());

			$leagueExperiences[] = $this->leagueExperienceRepository->create([
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

	public function getLeagueExperiences($steamId, $updatedRequired = false)
	{
		if ($updatedRequired)
		{
			return $this->updateLeagueExperiences($steamId);
		}
		else
		{
			return $this->leagueExperienceRepository->getAllBySteamId($steamId);
		}
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