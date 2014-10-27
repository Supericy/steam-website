<?php namespace Icy\Favourite;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/26/2014
 * Time: 3:55 AM
 */

class FavouriteServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('Icy\Favourite\IFavouriteService', function ($app)
		{
			return $app->make('Icy\Favourite\FavouriteService');
		});
	}

}