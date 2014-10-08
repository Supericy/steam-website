<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 1:34 AM
 */

interface IFollowManager {

	/**
	 * @param int $userId
	 * @param int $steamIdId
	 */
	public function follow($userId, $steamIdId);

	public function unfollow($userId, $steamId);

	public function isFollowing($userId, $steamIdId);

	public function enableNotifications($userId, $steamIdId, $banName);

	public function disableNotifications($userId, $steamIdId, $banName);

} 