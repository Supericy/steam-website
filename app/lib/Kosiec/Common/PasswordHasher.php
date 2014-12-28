<?php namespace Kosiec\Common;
use Illuminate\Hashing\HasherInterface;
use Kosiec\ValueObject\Password;
use Kosiec\ValueObject\PasswordHash;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/25/2014
 * Time: 1:38 AM
 */

class PasswordHasher {

	/**
	 * @param Password $password
	 * @return PasswordHash
	 */
	public function hash(Password $password)
	{
		return new PasswordHash(password_hash($password->string(), PASSWORD_BCRYPT ));
	}

	public function verify(Password $password, PasswordHash $passwordHash)
	{
		return password_verify($password->string(), $passwordHash->string());
	}

}