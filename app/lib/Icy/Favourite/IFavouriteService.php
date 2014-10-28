<?php namespace Icy\Favourite;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 1:34 AM
 */

interface IFavouriteService {

	/**
	 * @param $userId
	 * @return mixed
	 */
	public function getAllFavourites($userId);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 */
	public function favourite($userId, $steamIdId);

	/**
	 * @param int $userId
	 * @param int $steamId
	 */
	public function unfavourite($userId, $steamId);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @return bool
	 */
	public function isFavourited($userId, $steamIdId);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @param string $banName
	 */
	public function enableNotification($userId, $steamIdId, $banName);

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 * @param string $banName
	 */
	public function disableNotification($userId, $steamIdId, $banName);

} 