<?php namespace Icy\Favourite;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:47 AM
 */

class FavouriteRepository implements IFavouriteRepository {

	private $model;

	public function __construct(Favourite $model)
	{
		$this->model = $model;
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

}