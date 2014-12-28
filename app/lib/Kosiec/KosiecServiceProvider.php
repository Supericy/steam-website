<?php namespace Kosiec;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 12/22/2014
 * Time: 7:25 PM
 */

class KosiecServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('\Kosiec\Repository\IUserAccountRepository', function ()
		{
			return new Repository\Doctrine\DoctrineUserAccountRepository(
				$this->app->make('\Doctrine\ORM\EntityManagerInterface'),
				$this->app->make('\Doctrine\ORM\Mapping\ClassMetadataFactory')->getMetadataFor('Kosiec\Entity\UserAccount'));
		});
	}

}