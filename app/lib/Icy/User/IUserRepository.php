<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

interface IUserRepository {

	/**
	 * @param $code
	 * 		The activation code for the user we want to activate.
	 * @return bool
	 * 		Returns true if a user was successfully activated, false in every other case
	 */
	public function activate($code);

	/**
	 * @param $code
	 * @return User
	 */
	public function getByActivationCode($code);

	public function getByEmail($email);

	public function getByAuthToken($token);

	public function create(array $values);

	public function firstOrCreate(array $credentials);

	public function getByProviderNameAndAccountId($provider, $accountId);

	public function normalize($credentials);

	/**
	 * Checks whether the credentials passed in contains all the nessessary fields (array keys). This method does NOT
	 * check data types.
	 *
	 * @param array $credentials
	 * 		Array of credentials we want to check
	 * @return bool
	 */
	public function isMissingFields(array $credentials);

	/**
	 * @param User $user
	 * @return bool
	 */
	public function save(User $user);

}