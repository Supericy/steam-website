<?php namespace Icy\Ban;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/8/2014
 * Time: 8:22 PM
 */

class BanServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('Icy\Ban\IBanDetectionRepository', function ($app)
		{
			return $app->make('Icy\Ban\BanDetectionRepository');
		});

		$this->app->singleton('Icy\Ban\IBanTypeRepository', function ($app)
		{
			return $app->make('Icy\Ban\BanTypeRepository');
		});

		$this->app->singleton('Icy\Ban\IBanNotificationRepository', function ($app)
		{
			return $app->make('Icy\Ban\BanNotificationRepository');
		});
	}

}