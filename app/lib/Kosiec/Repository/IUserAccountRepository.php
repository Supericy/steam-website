<?php namespace Kosiec\Repository;
use Kosiec\Entity\UserAccount;
use Kosiec\ValueObject\ActivationCode;
use Kosiec\ValueObject\Email;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 3:50 PM
 */

interface IUserAccountRepository {

	/**
	 * @param UserAccount $userAccount
	 */
	public function store(UserAccount $userAccount);

	/**
	 * @param ActivationCode $activationCode
	 * @return UserAccount|null
	 */
	public function findByActivationCode(ActivationCode $activationCode);

	/**
	 * @param Email $email
	 * @return UserAccount|null
	 */
	public function findByEmail(Email $email);

}