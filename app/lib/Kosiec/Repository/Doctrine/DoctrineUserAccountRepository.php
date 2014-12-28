<?php namespace Kosiec\Repository\Doctrine;
use Doctrine\ORM\EntityRepository;
use Kosiec\Entity\UserAccount;
use Kosiec\Repository\IUserAccountRepository;
use Kosiec\Service\UserAccountCredentials;
use Kosiec\ValueObject\ActivationCode;
use Kosiec\ValueObject\Email;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 3:53 PM
 */

class DoctrineUserAccountRepository extends EntityRepository implements IUserAccountRepository {

	public function store(UserAccount $userAccount)
	{
		$this->_em->persist($userAccount);
		$this->_em->flush();
	}

	public function findByActivationCode(ActivationCode $activationCode)
	{
		return $this->findOneBy(['activationCode' => $activationCode->string()]);
	}

	public function findByEmail(Email $email)
	{
		return $this->findOneBy([
			'email' => $email->string(),
		]);
	}

}