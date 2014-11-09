<?php namespace Icy\Ban;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 4:36 PM
 */

interface IBanDetectionRepository {

	/**
	 * @param $steamIdId
	 * @param $banName
	 * @param bool $isBanned
	 * @return BanDetection
	 */
	public function newDetection($steamIdId, $banName, $isBanned);

}