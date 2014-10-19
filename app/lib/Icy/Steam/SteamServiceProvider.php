<?php namespace Icy\Steam;

class SteamServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\Steam\Web\ISteamWebAPI', function ($app)
		{
			$api = $app->make('Icy\Steam\Web\SteamWebAPI');
			$api->setApiKey($app['config']['steam.api_key']);

			return $api;
		});

		$this->app->bind('Icy\Steam\ISteamService', function ($app)
		{
			$steamService = $app->make('Icy\Steam\SteamService');
			$steamService->setBaseCommunityUrl($app['config']['steam']['base_community_url']);

			return $steamService;
		});

		$this->app->bind('Icy\Steam\ISteamIdRepository', function ($app)
		{
			return $app->make('Icy\Steam\SteamIdRepository');
		});
	}

}