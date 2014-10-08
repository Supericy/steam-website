<?php namespace Icy\Esea;
use Icy\Common\IBanStatus;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/3/2014
 * Time: 3:13 PM
 */

class EseaBanStatus implements IBanStatus {

	private $isBanned;
	private $eseaBan;

	/**
	 * @param bool $isBanned
	 * @param EseaBan $eseaBan
	 */
	public function __construct($isBanned, EseaBan $eseaBan = null)
	{
		$this->isBanned = $isBanned;
		$this->eseaBan = $eseaBan;
	}

	public function isBanned()
	{
		return $this->isBanned;
	}

	public function getTimestamp()
	{
		if (!$this->isBanned())
			return null;

		return $this->eseaBan->timestamp;
	}

	public function getBanName()
	{
		return 'ESEA';
	}

	public function getAlias()
	{
		if (!$this->isBanned())
			return IBanStatus::UNKNOWN_ALIAS;

		return $this->eseaBan->alias;
	}

} 