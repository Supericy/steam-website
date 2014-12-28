<?php namespace Kosiec\ValueObject;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 6:16 PM
 */

class PasswordHash {

	/**
	 * @var string
	 */
	private $passwordHash;

	/**
	 * @param $passwordHash
	 */
	public function __construct($passwordHash)
	{
		$this->passwordHash = $passwordHash;
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
		return $this->passwordHash;
	}

}