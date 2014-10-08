<?php namespace Icy\Steam;
use Icy\Esea\EseaBanStatus;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/28/14
 * Time: 5:13 AM
 */

class SteamId extends \Eloquent {

    protected $table = 'steamids';

	protected $guarded = array('id');

	public function banListeners()
	{
		return $this->hasMany('Icy\BanListener\BanListener', 'steamid_id');
	}

	public function banDetections()
	{
		return $this->hasMany('Icy\BanDetection\BanDetection', 'steamid_id');
	}

	public function eseaBan()
	{
		return $this->hasOne('Icy\Esea\EseaBan', 'steamid', 'steamid');
	}

	public function hasBans()
	{
		// TODO: maybe keep track of if they have a ban inside the table, so that we don't need to query all of the bans

		$bans = $this->getAllBanStatuses();

		/**
		 * @var \Icy\Common\IBanStatus $ban
		 */
		foreach ($bans as $ban)
		{
			if ($ban->isBanned())
				return true;
		}

		return false;
	}

	public function getAllBanStatuses()
	{
		return [
			$this->getVacBanStatus(),
			$this->getEseaBanStatus(),
		];
	}

	public function getVacBanStatus()
	{
		return new VacBanStatus($this->vac_banned, $this->days_since_last_ban);
	}

	public function getEseaBanStatus()
	{
		$isBanned = false;
		$banTimestamp = null;

		if ($this->eseaBan)
		{
			$isBanned = true;
		}

		return new EseaBanStatus($isBanned, $this->eseaBan);
	}

}