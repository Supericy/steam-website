<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:30 PM
 */

interface IBanManager {

	public function createBanListener($userId, $steamIdId);

	public function updateVacStatus($steamId, $newVacStatus = null);

	public function steamIdBeingTracked($steamId);

	public function isUserFollowing($userId, $steamIdId);

}