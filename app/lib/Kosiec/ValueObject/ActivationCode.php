<?php namespace Kosiec\ValueObject;
use Illuminate\Support\Str;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 6:31 PM
 */

class ActivationCode {

	const PATTERN = '/^[a-z0-9]{32}$/';

	/**
	 * @var string
	 */
	private $activationCode;

	function __construct($activationCode)
	{
		$activationCode = Str::lower($activationCode);

		if (empty($activationCode) || ! preg_match(self::PATTERN, $activationCode))
			throw new \InvalidArgumentException("Activation code is not valid");

		$this->activationCode = $activationCode;
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
		return $this->activationCode;
	}

	/**
	 * @return ActivationCode 32 characters long
	 */
	public static function generate()
	{
		return new ActivationCode(bin2hex(openssl_random_pseudo_bytes(16)));
	}

}