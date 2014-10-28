<?php namespace Icy;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/13/2014
 * Time: 2:21 AM
 */

class VendorServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('\GuzzleHttp\ClientInterface', function ($app)
		{
			return $app->make('\GuzzleHttp\Client');
		});
	}

} 