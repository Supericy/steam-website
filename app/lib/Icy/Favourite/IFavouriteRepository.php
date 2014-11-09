<?php namespace Icy\Favourite;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:48 AM
 */

interface IFavouriteRepository {

	/**
	 * @param $userId
	 * @param $steamIdId
	 * @return Favourite
	 */
	public function getByUserIdAndSteamIdId($userId, $steamIdId);

	/**
	 * @param $userId
	 * @return Collection
	 */
	public function getAllByUserId($userId);

	/**
	 * @param $userId
	 * @param $steamIdId
	 * @return bool
	 */
	public function favourite($userId, $steamIdId);

	/**
	 * @param $userId
	 * @param $steamIdId
	 * @return bool
	 */
	public function unfavourite($userId, $steamIdId);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @return bool
	 */
	public function isFavourited($userId, $steamIdId);

} 