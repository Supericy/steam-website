<?php namespace Icy\BanNotification;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 2:30 AM
 */

interface IBanNotificationRepository {

	/**
	 * @param array $values
	 * @return BanNotification
	 */
	public function create(array $values);

	/**
	 * @param array $arrayOfValues
	 * @return BanNotification[]
	 */
	public function createMany(array $arrayOfValues);

	/**
	 * @param int $favouriteId
	 * @return BanNotification[]
	 */
	public function createForAllBanTypes($favouriteId);

	/**
	 * @param int $favouriteId
	 * @return BanNotification
	 */
	public function getByFavouriteId($favouriteId);

	/**
	 * @param int $favouriteId
	 * @param string $banName
	 * @return BanNotification
	 */
	public function getByFavouriteIdAndBanName($favouriteId, $banName);

	/**
	 * @param int $favouriteId
	 * @param int $banTypeId
	 * @return BanNotification
	 */
	public function getByFavouriteIdAndBanTypeId($favouriteId, $banTypeId);

}