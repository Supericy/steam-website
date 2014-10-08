<?php namespace Icy\Steam;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/3/2014
 * Time: 2:41 AM
 */

use \Carbon\Carbon;
use Icy\Common\IBanStatus;

class VacBanStatus implements IBanStatus {

	private $vacBanned;
	private $daysSinceLastBan;

	/**
	 * @param bool $vacBanned
	 * @param null|int $daysSinceLastBan
	 */
	public function __construct($vacBanned, $daysSinceLastBan = null)
	{
		$this->vacBanned = $vacBanned;
		$this->daysSinceLastBan = $daysSinceLastBan;
	}

	public function isBanned()
	{
		return $this->vacBanned;
	}

	public function getTimestamp()
	{
		if (!$this->isBanned())
			return null;

		return Carbon::now()->subDays($this->getDaysSinceLastBan())->timestamp;
	}

	public function getBanName()
	{
		return 'VAC';
	}

	/**
	 * @return int|null
	 * 		Returns null if isBanned returns false
	 */
	public function getDaysSinceLastBan()
	{
		if (!$this->isBanned())
			return null;

		return $this->daysSinceLastBan;
	}

	/**
	 * @return string
	 */
	public function getAlias()
	{
		return IBanStatus::UNKNOWN_ALIAS;
	}


} 