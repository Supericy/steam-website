<?php namespace Icy\User;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/27/2014
 * Time: 11:03 PM
 */



interface IActivationManager {

	/**
	 * @param int $userId
	 * @return \Icy\User\ActivationCode
	 */
	public function createActivationCode($userId);

	/**
	 * @param string $email
	 * 	User's email to send activation URL to
	 * @param string $code
	 * 	User's activation code
	 */
	public function sendActivationEmail($email, $code);

	/**
	 * @param (Icy\User\ActivationCode|string) $code
	 * @return bool
	 */
	public function activate($code);

} 