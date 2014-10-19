<?php namespace Icy;

use Illuminate\Cache\Repository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 10:24 AM
 */
class BanManager implements IBanManager {

	private $steam;
	private $steamIdRepository;
	private $banListener;
	private $banDetectionRepository;
	private $banTypeRepository;
	private $cache;

	// increment times checked on vacStatusUpdate
	private $incrementOnUpdate;

	public function __construct(
		Steam\ISteamService $steam,
		Steam\ISteamIdRepository $steamIdRepository,
		BanDetection\IBanDetectionRepository $banDetectionRepository,
		BanDetection\IBanTypeRepository $banTypeRepository,
		Repository $cache)
	{
		$this->steam = $steam;
		$this->steamIdRepository = $steamIdRepository;
		$this->banDetectionRepository = $banDetectionRepository;
		$this->banTypeRepository = $banTypeRepository;
		$this->cache = $cache;

		$this->incrementOnUpdate = true;
	}

	public function incrementOnUpdate($bool)
	{
		$this->incrementOnUpdate = $bool;
	}

	// we can pass in the new vac status, incase we already have it and don't want to make the API call
	public function fetchAndUpdate($potentialId, Steam\VacBanStatus $newVacStatus = null)
	{
		if ($potentialId instanceof Steam\SteamId)
		{
			$steamId = $potentialId->steamid;

			$steamIdRecord = $potentialId;
		} else
		{
			$steamId = $this->steam->resolveId($potentialId);

			$steamIdRecord = $this->steamIdRepository->firstOrCreate([
				'steamid' => $steamId
			]);
		}

		if ($this->incrementOnUpdate)
			$steamIdRecord->increment('times_checked');

		$this->checkForVacBans($steamIdRecord, $newVacStatus);
		$this->checkForEseaBans($steamIdRecord);

		return $steamIdRecord;
	}

	private function checkForVacBans(Steam\SteamId $steamIdRecord, Steam\VacBanStatus $newVacStatus = null)
	{
		if ($newVacStatus === null)
			$newVacStatus = $this->steam->getVacBanStatus($steamIdRecord->steamid);

		if ($newVacStatus->isBanned() != $steamIdRecord->vac_banned)
		{
			$steamIdRecord->vac_banned = $newVacStatus->isBanned();
			$steamIdRecord->changed = true;
			$steamIdRecord->days_since_last_ban = $newVacStatus->getDaysSinceLastBan();

			$this->steamIdRepository->save($steamIdRecord);

			$this->createBanDetection($steamIdRecord, $newVacStatus);
		}
	}

	private function checkForEseaBans(Steam\SteamId $steamIdRecord)
	{
		$newEseaStatus = $steamIdRecord->getEseaBanStatus();

		if ($newEseaStatus->isBanned())
		{
			$this->createBanDetection($steamIdRecord, $newEseaStatus);
		}
	}

	private function createBanDetection(Steam\SteamId $steamIdRecord, Common\IBanStatus $banStatus)
	{
		$banType = $this->banTypeRepository->getByName($banStatus->getBanName());

		$banDetectionRecord = $this->banDetectionRepository->firstOrCreate([
			'steamid_id' => $steamIdRecord->id,
			'ban_type_id' => $banType->id,
			'ban_status' => $banStatus->isBanned(),
		]);

		return $banDetectionRecord;
	}

}