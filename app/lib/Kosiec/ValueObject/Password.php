<?php namespace Kosiec\ValueObject;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/25/2014
 * Time: 4:06 PM
 */

class Password {

	/**
	 * @var string
	 */
	private $password;

	public function __construct($password)
	{
		$this->password = $password;
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
		return $this->password;
	}

}