<?php namespace Kosiec;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Kosiec\Service\Steam\SteamWebApi;

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

		$this->app->bind('\Kosiec\Service\Steam\ISteamWebApi', function ()
		{
			return new SteamWebApi(new Client(), $this->app->make('cache.store'), $this->app['config']['steam.api_key']);
		});
	}

}