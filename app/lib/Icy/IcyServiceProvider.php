<?php namespace Icy;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 9:32 AM
 */

class IcyServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		/*
		 * Bind third-party libraries to our IoC
		 */
		$this->app->register('Icy\VendorServiceProvider');

		/*
		 * Load all of our service providers
		 */
		$providers = [
			'Icy\User\UserServiceProvider',
			'Icy\Steam\SteamServiceProvider',
			'Icy\Ban\BanServiceProvider',
			'Icy\OAuth\OAuthServiceProvider',
			'Icy\LegitProof\LegitProofServiceProvider',
			'Icy\Favourite\FavouriteServiceProvider',
			'Icy\Authentication\AuthenticationServiceProvider',
		];

		foreach ($providers as $provider)
			$this->app->register($provider);

		/*
		 * Bind Services that don't have a provider yet
		 */

		$this->app->bind('Icy\IBanService', function ($app)
		{
			return $app->make('Icy\BanService');
		});

		$this->app->bind('Icy\ILeagueExperienceService', function ($app)
		{
			return $app->make('Icy\LeagueExperienceService');
		});
	}

}