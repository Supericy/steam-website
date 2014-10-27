<?php namespace Icy\Favourite;
use Icy\BanNotification\IBanNotificationRepository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/5/2014
 * Time: 10:31 PM
 */

class FavouriteService implements IFavouriteService {

	private $favouriteRepository;
	private $banNotificationRepository;

	public function __construct(IFavouriteRepository $favouriteRepository, IBanNotificationRepository $banNotificationRepository)
	{
		$this->favouriteRepository = $favouriteRepository;
		$this->banNotificationRepository = $banNotificationRepository;
	}

	public function getAllFavourites($userId)
	{
		return $this->favouriteRepository->getAllByUserId($userId);
	}

	public function favourite($userId, $steamIdId)
	{
		$favouriteRecord = $this->favouriteRepository->firstOrCreate([
			'user_id' => $userId,
			'steamid_id' => $steamIdId
		]);

		// create all the ban notifications, by default, they will all be enabled
		$this->banNotificationRepository->createForAllBanTypes($favouriteRecord->id);

		return $favouriteRecord;
	}

	public function unfavourite($userId, $steamIdId)
	{
		$favouriteRecord = $this->favouriteRepository->getByUserIdAndSteamIdId($userId, $steamIdId);

		if ($favouriteRecord)
		{
			// should cascade
//			$favouriteRecord->delete();
			$this->favouriteRepository->delete($favouriteRecord);
		}
	}

	public function isFavourited($userId, $steamIdId)
	{
		return $this->favouriteRepository->isFavourited($userId, $steamIdId);
	}

	public function enableNotification($userId, $steamIdId, $banName)
	{
		$banNotificationRecord = $this->getBanNotificationRecord($userId, $steamIdId, $banName);

		// only save if its currently not enabled
		if (!$banNotificationRecord->enabled)
		{
			$banNotificationRecord->enabled = true;

			$this->banNotificationRepository->save($banNotificationRecord);
		}
	}

	public function disableNotification($userId, $steamIdId, $banName)
	{
		$banNotificationRecord = $this->getBanNotificationRecord($userId, $steamIdId, $banName);

		// only save if its currently enabled
		if ($banNotificationRecord->enabled)
		{
			$banNotificationRecord->enabled = false;

			$this->banNotificationRepository->save($banNotificationRecord);
		}
	}

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @param string $banName
	 * @return BanNotification\BanNotification
	 */
	private function getBanNotificationRecord($userId, $steamIdId, $banName)
	{
		$favouriteRecord = $this->favouriteRepository->getByUserIdAndSteamIdId($userId, $steamIdId);

		return $this->banNotificationRepository->getByFavouriteIdAndBanName($favouriteRecord->id, $banName);
	}

//	private function isFollowingCacheKey($userId, $steamIdId)
//	{
//		return sprintf('%d_is_following_%d', $userId, $steamIdId);
//	}

} 