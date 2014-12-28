<?php namespace Kosiec\Factory;
use Kosiec\Common\PasswordHasher;
use Kosiec\Service\UserAccountCredentials;
use Kosiec\ValueObject\Email;
use Kosiec\ValueObject\Password;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/25/2014
 * Time: 3:07 AM
 */

class UserAccountCredentialsFactory {

	public function create($email, $password)
	{
		return new UserAccountCredentials(new Email($email), new Password($password));
	}

}