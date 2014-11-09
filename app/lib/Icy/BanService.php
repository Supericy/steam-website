<?php namespace Icy;

use Icy\Esea\EseaBanStatus;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 10:24 AM
 */
class BanService implements IBanService {

	private $steam;
	private $steamIdRepository;
	private $banDetectionRepository;

	public function __construct(
		Steam\ISteamService $steam,
		Steam\ISteamIdRepository $steamIdRepository,
		Ban\IBanDetectionRepository $banDetectionRepository)
	{
		$this->steam = $steam;
		$this->steamIdRepository = $steamIdRepository;
		$this->banDetectionRepository = $banDetectionRepository;
	}

	public function checkForVacBans(Steam\SteamId $steamIdRecord, Steam\VacBanStatus $newVacStatus = null)
	{
		if ($newVacStatus === null)
			$newVacStatus = $this->steam->getVacBanStatus($steamIdRecord->steamid);

		if ($newVacStatus->isBanned() != $steamIdRecord->vac_banned)
		{
			$steamIdRecord->vac_banned = $newVacStatus->isBanned();
			$steamIdRecord->changed = true;
			$steamIdRecord->days_since_last_ban = $newVacStatus->getDaysSinceLastBan();

			$this->steamIdRepository->save($steamIdRecord);

			$this->banDetectionRepository->newDetection($steamIdRecord->id, $newVacStatus->getBanName(), $newVacStatus->isBanned());
		}
	}

	public function checkForEseaBans(Steam\SteamId $steamIdRecord, EseaBanStatus $newEseaStatus = null)
	{
		if ($newEseaStatus === null)
			$newEseaStatus = $steamIdRecord->getEseaBanStatus();

		if ($newEseaStatus->isBanned())
		{
			$this->banDetectionRepository->newDetection($steamIdRecord->id, $newEseaStatus->getBanName(), $newEseaStatus->isBanned());
		}
	}

}