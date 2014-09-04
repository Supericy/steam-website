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
		$providers = [
			'Icy\User\UserServiceProvider',
			'Icy\Steam\SteamServiceProvider',
			'Icy\BanListener\BanListenerServiceProvider',
			'Icy\BanDetection\BanDetectionServiceProvider',
		];

		foreach ($providers as $provider)
			$this->app->register($provider);

		$this->app->bind('Icy\IBanManager', function ($app) {
			return $app->make('Icy\BanManager');
		});
	}

}