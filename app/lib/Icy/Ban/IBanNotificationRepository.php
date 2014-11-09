<?php namespace Icy\Ban;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 2:30 AM
 */

interface IBanNotificationRepository {

	/**
	 * @param int $favouriteId
	 * @return BanNotification[]
	 */
	public function createForAllBanTypes($favouriteId);

	/**
	 * @param int $favouriteId
	 * @param string $banName
	 * @return bool
	 */
	public function enableNotification($favouriteId, $banName);

	/**
	 * @param int $favouriteId
	 * @param string $banName
	 * @return bool
	 */
	public function disableNotification($favouriteId, $banName);

	/**
	 * @param int $favouriteId
	 * @param string $banName
	 * @param bool $enabled
	 * @return bool
	 */
	public function toggleNotification($favouriteId, $banName, $enabled);

	/**
	 * @param BanNotification $banNotification
	 * @return bool
	 */
	public function save(BanNotification $banNotification);

}