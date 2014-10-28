<?php namespace Icy\OAuth;
use Icy\User\User;

interface IOAuthService {

	/**
	 * @param $providerName
	 * @param $accountId
	 * @param bool $remember
	 * @return User
	 */
	public function login($providerName, $accountId, $remember = true);

	// TODO: remove dependency on EloquentUser record
	public function getLoginMethods(User $userRecord);

	public function getLoginMethodsByEmail($email);

	public function createOAuthAccount($userId, $providerName, $accountId);

}