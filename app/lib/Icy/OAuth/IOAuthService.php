<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 3:50 PM
 */
namespace Icy\OAuth;

interface IOAuthService {

	public function attemptLogin($providerName, $accountId, $remember = true);

	// TODO: remove dependency on EloquentUser record
	public function getLoginMethods(\Icy\User\User $userRecord);

	public function getLoginMethodsByEmail($email);

	public function createOAuthAccount($userId, $providerName, $accountId);

}