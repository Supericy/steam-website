<?php namespace Icy\Favourite;
use Icy\Common\AbstractRepository;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:47 AM
 */

class FavouriteRepository extends AbstractRepository implements IFavouriteRepository {

	private $model;

	public function __construct(Favourite $model)
	{
		$this->model = $model;
	}

	/**
	 * @param $userId
	 * @return mixed
	 */
	public function getAllByUserId($userId)
	{
		$recordsArray = $this->model
			->where('user_id', $userId)
			->leftJoin('users', 'favourites.user_id', '=', 'users.id')
			->leftJoin('steamids', 'favourites.steamid_id', '=', 'steamids.id')
			->get()->toArray();

		return $this->toObject($recordsArray);
	}

	public function isFavourited($userId, $steamIdId)
	{
		return $this->model
			->where('user_id', $userId)
			->where('steamid_id', $steamIdId)
			->count() > 0;
	}

	public function firstOrCreate(array $values)
	{
		return $this->model->firstOrCreate($values);
	}

	public function getByUserIdAndSteamIdId($userId, $steamIdId)
	{
		return $this->model
			->where('user_id', $userId)
			->where('steamid_id', $steamIdId)
			->first();
	}

	public function delete(Favourite $record)
	{
		return $record->delete();
	}

}