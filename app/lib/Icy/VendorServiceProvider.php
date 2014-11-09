<?php namespace Icy;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/13/2014
 * Time: 2:21 AM
 */

class VendorServiceProvider extends ServiceProvider {

	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('GuzzleHttp\ClientInterface', function ($app)
		{
			return $app->make('GuzzleHttp\Client');
		});
	}

	public function provides()
	{
		return ['GuzzleHttp\ClientInterface'];
	}

}