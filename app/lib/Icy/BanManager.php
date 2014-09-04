<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 10:24 AM
 */

class BanManager implements IBanManager {

	private $steam;
	private $steamId;
	private $banListener;
	private $banDetection;

	public function __construct(Steam\ISteamService $steam, Steam\ISteamIdRepository $steamId, BanListener\IBanListenerRepository $banListener, BanDetection\IBanDetectionRepository $banDetection)
	{
		$this->steam = $steam;
		$this->steamId = $steamId;
		$this->banListener = $banListener;
		$this->banDetection = $banDetection;
	}

	public function createBanListener($userId, $potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		$steamIdRecord = $this->steamId->firstOrCreateAndUpdateVacStatus([
			'steamid' => $steamId
		]);

		$banListenerRecord = $this->banListener->firstOrCreate([
			'user_id' => $userId,
			'steamid_id' => $steamIdRecord->id
		]);

		return $banListenerRecord;
	}

	// we can pass in the new vac status, incase we already have it and don't want to make the API call
	public function updateVacStatus($potentialId, $newVacStatus = null)
	{
		if ($potentialId instanceof Steam\SteamId)
		{
			$steamId = $potentialId->steamid;
			$record = $potentialId;
		}
		else
		{
			$steamId = $this->steam->resolveId($potentialId);

			$record = $this->steamId->firstOrCreate([
				'steamid' => $steamId
			]);
		}

		// forces us to hit the database, which isn't ideal in some situations, so lets not increment this for now
		// TODO: optimize and re-implement
//		$record->increment('times_checked');

		if ($newVacStatus === null)
			$newVacStatus = $this->steam->isVacBanned($record->steamid);

		if ($newVacStatus != $record->vac_banned)
		{
			$record->vac_banned = $newVacStatus;
			$record->changed = true;

			$this->banDetection->firstOrCreate([
				'steamid_id' => $record->id,
				'new_vac_status' => $newVacStatus,
			]);

			$this->steamId->save($record);
		}

		return $record;
	}

}