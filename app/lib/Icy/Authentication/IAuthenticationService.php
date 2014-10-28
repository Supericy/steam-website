<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/27/2014
 * Time: 5:39 PM
 */
namespace Icy\Authentication;


/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/27/2014
 * Time: 5:04 PM
 */
interface IAuthenticationService {

	/**
	 * @param array $credentials
	 * @param bool $remember
	 * @return mixed
	 */
	public function login(array $credentials = array(), $remember = true);

	public function oauthLogin($providerName, $accountId, $remember = true);

	public function forceLoginUsingId($userId, $remember = true);

	public function logout();

	public function userId();

	public function user();

}