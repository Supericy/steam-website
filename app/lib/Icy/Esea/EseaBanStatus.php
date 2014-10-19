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
	private $alias;
	private $timestamp;

	/**
	 * @param bool $isBanned
	 * @param string $alias
	 * @param int $timestamp
	 */
	public function __construct($isBanned, $alias = null, $timestamp = null)
	{
		$this->isBanned = $isBanned;
		$this->alias = $alias;
		$this->timestamp = $timestamp;
	}

	public function isBanned()
	{
		return $this->isBanned;
	}

	public function getTimestamp()
	{
		if (!$this->isBanned())
			return null;

		return $this->timestamp;
	}

	public function getBanName()
	{
		return 'ESEA';
	}

	public function getAlias()
	{
		if (!$this->isBanned())
			return IBanStatus::UNKNOWN_ALIAS;

		return $this->alias;
	}

} 