<?php namespace Kosiec\ValueObject;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 6:01 PM
 */

class Email {

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @param string $email
	 */
	public function __construct($email)
	{
		$email = Str::lower($email);

		if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL))
			throw new InvalidArgumentException("Email is not valid");

		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->string();
	}

	/**
	 * @return string
	 */
	public function string()
	{
		return $this->email;
	}

}