<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/24/2014
 * Time: 12:04 AM
 */

class OAuthEmailTakenException extends \Exception {

	private $loginMethods;

	public function __construct(array $loginMethods = [])
	{
		$this->loginMethods = $loginMethods;
	}

	public function getLoginMethods()
	{
		return $this->loginMethods;
	}

}