<?php namespace Icy\Favourite;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 12:48 AM
 */

interface IFavouriteRepository {

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @return bool
	 */
	public function isFavourited($userId, $steamIdId);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @return Favourite
	 */
	public function getByUserIdAndSteamIdId($userId, $steamIdId);

	/**
	 * @param array $values
	 * @return Favourite
	 */
	public function firstOrCreate(array $values);

	/**
	 * @param Favourite
	 * @return bool
	 */
	public function delete(Favourite $record);

} 