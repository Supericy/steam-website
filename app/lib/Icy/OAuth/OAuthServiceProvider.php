<?php namespace Icy\OAuth;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/22/2014
 * Time: 3:02 AM
 */

class OAuthServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\OAuth\IOAuthProviderRepository', function ($app) {
			return new OAuthProviderRepository(new OAuthProvider());
		});

		$this->app->bind('Icy\OAuth\IOAuthAccountRepository', function ($app) {
			return new OAuthAccountRepository(new OAuthAccount(), $app->make('Icy\OAuth\IOAuthProviderRepository'));
		});

		$this->app->bind('Icy\OAuth\IOAuthManager', function ($app) {
			return $app->make('OAuthManager');
		});
	}


}