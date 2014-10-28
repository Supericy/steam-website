<?php namespace Icy\Common;

interface IBanStatus {

	const UNKNOWN_ALIAS = 'UNKNOWN_ALIAS';

	/**
	 * @return bool
	 */
	public function isBanned();

	/**
	 * @return int|null
	 *        Returns null if the user is not banned (ie. no timestamp exists...)
	 */
	public function getTimestamp();

	/**
	 * @return string
	 *        Name of ban type (ie. VAC, ESEA, etc).
	 */
	public function getBanName();

	/**
	 * @return string
	 */
	public function getAlias();

} 