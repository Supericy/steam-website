<?php namespace Icy\Steam;

use Icy\Common\DebugbarProfiler;
use Icy\Steam\Web\SteamWebAPI;

class SteamServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('Icy\Steam\Web\ISteamWebAPI', function ($app)
		{
			/** @var SteamWebAPI $api */
			$api = $app->make('Icy\Steam\Web\SteamWebAPI');
			$api->setApiKey($app['config']['steam.api_key']);

			$api->setProfiler(new DebugbarProfiler($app['debugbar']));

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