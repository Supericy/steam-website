<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/27/2014
 * Time: 10:53 PM
 */



/**
 * Interface IActivationCodeRepository
 * @package Icy\User
 */
interface IActivationCodeRepository {

	/**
	 * @param array $values
	 * @return ActivationCode
	 */
	public function create(array $values);

	/**
	 * @param string $code
	 * @return ActivationCode
	 */
	public function getByCode($code);

	/**
	 * @param ActivationCode $activationCode
	 * @return bool
	 */
	public function save(ActivationCode $activationCode);

	/**
	 * @param ActivationCode $activationCode
	 * @return bool
	 */
	public function delete(ActivationCode $activationCode);

}