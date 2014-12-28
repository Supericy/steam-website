<?php namespace Kosiec\Service;
use Kosiec\ValueObject\Email;
use Kosiec\ValueObject\Password;
use Kosiec\ValueObject\PasswordHash;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 6:24 PM
 */

class UserAccountCredentials {

	/**
	 * @var Email
	 */
	private $email;
	/**
	 * @var Password
	 */
	private $password;

	public function __construct(Email $email, Password $password)
	{
		$this->email = $email;
		$this->password = $password;
	}

	/**
	 * @return Email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return Password
	 */
	public function getPassword()
	{
		return $this->password;
	}

}