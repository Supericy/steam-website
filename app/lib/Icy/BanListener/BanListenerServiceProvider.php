<?php namespace Icy\BanListener;
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 7:10 PM
 */

class BanListenerServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\BanListener\IBanListenerRepository', function ($app)
		{
			return new BanListenerRepository(new BanListener());
		});
	}
}