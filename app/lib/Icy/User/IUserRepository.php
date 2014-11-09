<?php namespace Icy\User;
use Illuminate\Auth\UserProviderInterface;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 6:48 PM
 */

interface IUserRepository extends UserProviderInterface {

	/**
	 * @param int $id
	 * @return User
	 */
	public function getById($id);

	/**
	 * @param $code
	 *        The activation code for the user we want to activate.
	 * @return bool
	 *        Returns true if a user was successfully activated, false in every other case
	 */
	public function activate($code);

//	public function getByActivationCode($code);

	/**
	 * @param string $email
	 * @return User
	 */
	public function getByEmail($email);

//	public function getByAuthToken($token);

	/**
	 * @param array $values
	 * @return User
	 */
	public function create(array $values);

//	public function firstOrCreate(array $credentials);

	/**
	 * @param $provider
	 * @param $accountId
	 * @return User
	 */
	public function getByProviderNameAndAccountId($provider, $accountId);

	/**
	 * @param $credentials
	 * @return array
	 */
	public function normalize($credentials);

	/**
	 * Checks whether the credentials passed in contains all the nessessary fields (array keys). This method does NOT
	 * check data types.
	 *
	 * @param array $credentials
	 *        Array of credentials we want to check
	 * @return bool
	 */
	public function isMissingFields(array $credentials);

	/**
	 * @param User $user
	 * @return bool
	 */
	public function save(User $user);

}