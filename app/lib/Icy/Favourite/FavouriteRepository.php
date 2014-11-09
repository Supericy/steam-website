<?php namespace Icy\Favourite;
use Icy\Ban\IBanNotificationRepository;
use Icy\Common\AbstractRepository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:47 AM
 */

class FavouriteRepository extends AbstractRepository implements IFavouriteRepository {

	private $model;
	/**
	 * @var IBanNotificationRepository
	 */
	private $banNotificationRepository;

	public function __construct(Favourite $model, IBanNotificationRepository $banNotificationRepository)
	{
		$this->model = $model;
		$this->banNotificationRepository = $banNotificationRepository;
	}

	public function getByUserIdAndSteamIdId($userId, $steamIdId)
	{
		return $this->model
			->where('user_id', $userId)
			->where('steamid_id', $steamIdId)
			->first();
	}

	public function getAllByUserId($userId)
	{
		$records = $this->model
			->where('user_id', $userId)
			->get();

		return $records;
	}

	public function favourite($userId, $steamIdId)
	{
		$favouriteRecord = $this->model->firstOrCreate([
			'user_id' => $userId,
			'steamid_id' => $steamIdId
		]);

		// create all the ban notifications, by default, they will all be enabled
		$this->banNotificationRepository->createForAllBanTypes($favouriteRecord->id);

		return $favouriteRecord;
	}

	public function unfavourite($userId, $steamIdId)
	{
		$favouriteRecord = $this->model
			->where('user_id', $userId)
			->where('steamid_id', $steamIdId)
			->first();

		if ($favouriteRecord)
		{
			$favouriteRecord->delete();
		}
	}

	public function isFavourited($userId, $steamIdId)
	{
		return $this->model
			->where('user_id', $userId)
			->where('steamid_id', $steamIdId)
			->count() > 0;
	}

}