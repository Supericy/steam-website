<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 9:32 AM
 */

class IcyServiceProvider extends \Illuminate\Support\ServiceProvider {

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
		 * We'll put single binds here, so that we don't need to create
		 * a new service provider for every-single-table/repository.
		 *
		 * If we end up needing a service provider, then we'll extract
		 * the binds to it's own service provider
		 */
		$this->app->bind('Icy\Esea\IEseaBanRepository', function ($app)
		{
			return $app->make('Icy\Esea\EseaBanRepository');
		});

		$this->app->bind('Icy\Favourite\IFavouriteRepository', function ($app)
		{
			return $app->make('Icy\Favourite\FavouriteRepository');
		});

		$this->app->bind('Icy\BanNotification\IBanNotificationRepository', function ($app)
		{
			return $app->make('Icy\BanNotification\BanNotificationRepository');
		});


		/*
		 * Load all of our service providers
		 */
		$providers = [
			'Icy\User\UserServiceProvider',
			'Icy\Steam\SteamServiceProvider',
			'Icy\BanListener\BanListenerServiceProvider',
			'Icy\BanDetection\BanDetectionServiceProvider',
			'Icy\OAuth\OAuthServiceProvider',
			'Icy\LegitProof\LegitProofServiceProvider',
		];

		foreach ($providers as $provider)
			$this->app->register($provider);

		/*
		 * Bind Managers
		 */
		$this->app->bind('Icy\IFollowManager', function ($app)
		{
			return $app->make('Icy\FollowManager');
		});

		$this->app->bind('Icy\IBanManager', function ($app)
		{
			return $app->make('Icy\BanManager');
		});

		$this->app->bind('Icy\ILeagueExperienceManager', function ($app)
		{
			return $app->make('Icy\LeagueExperienceManager');
		});
	}

}