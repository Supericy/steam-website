<?php namespace Kosiec\Service\Authentication;
use Kosiec\ValueObject\ActivationCode;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/25/2014
 * Time: 3:31 AM
 */

class UserAccountNotActiveException extends \Exception {

	/**
	 * @var ActivationCode
	 */
	private $activationCode;

	public function __construct($message, ActivationCode $activationCode)
	{
		parent::__construct($message);
		$this->activationCode = $activationCode;
	}

	/**
	 * @return ActivationCode
	 */
	public function getActivationCode()
	{
		return $this->activationCode;
	}

}