<?php namespace Icy\Authentication;
use Icy\OAuth\IOAuthService;
use Icy\User\IUserService;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Guard;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/27/2014
 * Time: 5:04 PM
 */

class AuthenticationService implements IAuthenticationService {

	/**
	 * @var Guard
	 */
	private $auth;
	/**
	 * @var IOAuthService
	 */
	private $oauthService;
	/**
	 * @var IUserService
	 */
	private $userService;
	/**
	 * @param AuthManager $auth
	 * @param IOAuthService $oauthService
	 * @param IUserService $userService
	 */
	public function __construct(AuthManager $auth, IOAuthService $oauthService, IUserService $userService)
	{
		$this->auth = $auth;
		$this->oauthService = $oauthService;
		$this->userService = $userService;
	}

	public function forceLoginUsingId($userId, $remember = true)
	{
		$record = $this->auth->loginUsingId($userId, $remember);

		if (!$record)
			throw new AuthenticationException("Unable to force login using id, the user does not exist");

		return $record->toArray();
	}

	public function login(array $credentials, $remember = true)
	{
		$normalizedCredentials = $this->userService->normalizeCredentials($credentials);

		$success = $this->auth->attempt($normalizedCredentials, $remember);

		if (!$success)
			throw new AuthenticationException("Unable to login, bad credentials");

		return $success;
	}

	public function oauthLogin($providerName, $accountId, $remember = true)
	{
		$record = $this->oauthService->login($providerName, $accountId, $remember);

		if (!$record)
			throw new AuthenticationException("Unable to login via oauth, the requested account does not exist");

		$this->auth->login($record, $remember);

		return $record;
	}

	public function logout()
	{
		$this->auth->logout();
	}

	public function check()
	{
		return $this->auth->check();
	}

	public function userId()
	{
		$id = $this->auth->id();

		if (!$id)
			throw new AuthenticationException('Unable to get the users ID (probably not logged in).');

		return $this->auth->id();
	}

	public function currentUser()
	{
		return $this->auth->user();
	}

} 