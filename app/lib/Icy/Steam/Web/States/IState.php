<?php namespace Icy\Steam\Web\States;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/14/2014
 * Time: 4:03 AM
 */
interface IState {

	/**
	 * @return string
	 */
	public function string();

	/**
	 * @return int
	 */
	public function integer();

}