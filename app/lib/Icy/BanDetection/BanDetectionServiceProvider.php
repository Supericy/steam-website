<?php namespace Icy\BanDetection;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/2/14
 * Time: 9:35 AM
 */

class BanDetectionServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\BanDetection\IBanDetectionRepository', function ($app)
		{
			return $app->make('Icy\BanDetection\BanDetectionRepository');
		});

		$this->app->bind('Icy\BanDetection\IBanTypeRepository', function ($app)
		{
			return $app->make('Icy\BanDetection\BanTypeRepository');
		});
	}

}