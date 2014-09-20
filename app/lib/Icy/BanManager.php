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
	private $cache;

	// increment times checked on vacStatusUpdate
	private $incrementOnUpdate;

	public function __construct(
		Steam\ISteamService $steam,
		Steam\ISteamIdRepository $steamId,
		BanListener\IBanListenerRepository $banListener,
		BanDetection\IBanDetectionRepository $banDetection,
		\Illuminate\Cache\Repository $cache)
	{
		$this->steam = $steam;
		$this->steamId = $steamId;
		$this->banListener = $banListener;
		$this->banDetection = $banDetection;
		$this->cache = $cache;

		$this->incrementOnUpdate = true;
	}

	private function isUserFollowingCacheKey($userId, $steamIdId)
	{
		return sprintf('%d_is_following_%d', $userId, $steamIdId);
	}

	public function isUserFollowing($userId, $steamIdId)
	{
		// TODO: fix caching
		$cacheTime = 60; // minutes

		$isFollowing = $this->cache->remember($this->isUserFollowingCacheKey($userId, $steamIdId), $cacheTime, function () use ($userId, $steamIdId) {
			return $this->banListener->isUserFollowing($userId, $steamIdId);
		});

		return $isFollowing;
	}

	public function createBanListener($userId, $steamIdId)
	{
		$banListenerRecord = $this->banListener->firstOrCreate([
			'user_id' => $userId,
			'steamid_id' => $steamIdId
		]);

		return $banListenerRecord;
	}

	public function removeBanListener($userId, $steamIdId)
	{
		// When implementing this, remember to forget the value from the cache

		$banListenerRecord = $this->banListener->getByUserIdAndSteamIdId($userId, $steamIdId);

		if ($banListenerRecord)
		{
			$this->cache->forget($this->isUserFollowingCacheKey($userId, $steamIdId));
			$banListenerRecord->delete();
		}
	}

	public function incrementOnUpdate($bool)
	{
		$this->incrementOnUpdate = $bool;
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

		if ($this->incrementOnUpdate)
			$record->increment('times_checked');

		if ($newVacStatus === null)
			$newVacStatus = $this->steam->isVacBanned($record->steamid);

		if ($newVacStatus != $record->vac_banned)
		{
			$record->vac_banned = $newVacStatus;
			$record->changed = true;

			$this->banDetection->create([
				'steamid_id' => $record->id,
				'new_vac_status' => $newVacStatus,
			]);

			$this->steamId->save($record);
		}

		return $record;
	}

	public function steamIdBeingTracked($potentialId)
	{
		$steamId = $this->steam->resolveId($potentialId);

		if ($steamId === false)
			return false;

		if ($this->steamId->getBySteamId($steamId))
			return true;
		else
			return false;
	}

}