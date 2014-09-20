<?php namespace Icy\BanListener;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:58 PM
 */

class BanListenerRepository implements IBanListenerRepository {

	private $model;

	public function __construct(BanListener $model)
	{
		$this->model = $model;
	}

	public function isUserFollowing($userId, $steamIdId)
	{
		return $this->model
			->where('user_id', '=', $userId)
			->where('steamid_id', '=', $steamIdId)
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