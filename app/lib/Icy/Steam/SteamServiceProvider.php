<?php namespace Icy\Steam;

class SteamServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\Steam\ISteamService', function ($app) {
			return new SteamService(new Web\SteamWebAPI($app['config']['steam.api_key']), $app['config']['steam']);
		});

		$this->app->bind('Icy\Steam\ISteamIdRepository', function ($app) {
			return new SteamIdRepository(new SteamId(), $app->make('Icy\Steam\ISteamService'));
		});
	}

}