<?php namespace Icy\Esea;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 11/8/2014
 * Time: 8:19 PM
 */

class EseaServiceProviderServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('Icy\Esea\IEseaBanRepository', function ($app)
		{
			return $app->make('Icy\Esea\EseaBanRepository');
		});
	}

}