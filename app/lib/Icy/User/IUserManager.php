<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/16/2014
 * Time: 3:08 AM
 */
namespace Icy\User;


/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/16/2014
 * Time: 1:53 AM
 */
interface IUserManager {

	/**
	 * Does not include wrapping slashes (ie. -> /pattern/ <-)
	 */
	const ACTIVATION_CODE_PATTERN = '[A-Za-z0-9]{16}';

	/**
	 * @param $credentials
	 * @return bool
	 * 		Returns true if successful
	 * @throws UserException
	 */
	public function createAccount($credentials);

	/**
	 * @param $code
	 * @return bool
	 * 		Whether or not an account was activated
	 */
	public function activateAccount($code);

	/**
	 * @param $email
	 * 		Email address to send the activation code to
	 * @param $code
	 */
	public function sendActivationEmail($email, $code);

	/**
	 * @return string
	 */
	public function generateActivationCode();

	/**
	 * @param $code
	 * @return bool
	 * 		Returns true if the activation code is in an acceptable format
	 */
	public function verifyActivationCodeFormat($code);

	/**
	 * @param array $credentials
	 * @return array
	 */
	public function normalizeCredentials(array $credentials);

}