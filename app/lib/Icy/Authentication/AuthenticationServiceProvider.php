<?php namespace Icy\Authentication;
use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/27/2014
 * Time: 5:37 PM
 */

class AuthenticationServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bindShared('Icy\Authentication\IAuthenticationService', function ($app)
		{
			return $app->make('Icy\Authentication\AuthenticationService');
		});
	}

}