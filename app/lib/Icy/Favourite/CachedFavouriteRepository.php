<?php namespace Icy\Favourite;
use Icy\Common\AbstractCachedRepository;
use Illuminate\Cache\Repository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/7/2014
 * Time: 2:43 AM
 */

class AbstractCachedFavouriteRepository extends AbstractCachedRepository implements IFavouriteRepository {

	/**
	 * @var ISteamIdRepository
	 */
	private $repository;

	public function __construct($cache, IFavouriteRepository $repository)
	{
		parent::__construct($cache);
		$this->repository = $repository;
	}

	public function favourite($userId, $steamIdId)
	{
		// update cache directly
		$this->cache()->forever($this->generateIsFavouritedCacheKey($userId, $steamIdId), true);

		// forget our list of favourites
		$this->cache()->forget($this->generateGetAllByUserIdCacheKey($userId));

		return $this->repository->favourite($userId, $steamIdId);
	}

	public function unfavourite($userId, $steamIdId)
	{
		// update cache directly
		$this->cache()->forever($this->generateIsFavouritedCacheKey($userId, $steamIdId), false);

		// forget our list of favourites
		$this->cache()->forget($this->generateGetAllByUserIdCacheKey($userId));

		return $this->repository->unfavourite($userId, $steamIdId);
	}

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @return bool
	 */
	public function isFavourited($userId, $steamIdId)
	{
		$key = $this->generateIsFavouritedCacheKey($userId, $steamIdId);

		return $this->cache()->rememberForever($key, function () use ($userId, $steamIdId)
		{
			return $this->repository->isFavourited($userId, $steamIdId);
		});
	}

	public function getByUserIdAndSteamIdId($userId, $steamIdId)
	{
		return $this->repository->getByUserIdAndSteamIdId($userId, $steamIdId);
	}

	/**
	 * @param $userId
	 * @return mixed
	 */
	public function getAllByUserId($userId)
	{
		$key = $this->generateGetAllByUserIdCacheKey($userId);

		return $this->cache()->rememberForever($key, function () use ($userId)
		{
			return $this->repository->getAllByUserId($userId);
		});
	}

	private function generateGetAllByUserIdCacheKey($userId)
	{
		return 'get_all_by_user_id_' . $userId;
	}

	private function generateIsFavouritedCacheKey($userId, $steamIdId)
	{
		return 'is_favourited_' . $userId . '_' . $steamIdId;
	}

}