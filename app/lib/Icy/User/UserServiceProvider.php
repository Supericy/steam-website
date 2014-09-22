<?php namespace Icy\User;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 9/1/14
 * Time: 7:12 PM
 */

class UserServiceProvider extends \Illuminate\Support\ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\User\IUserRepository', function ($app) {
			return new UserRepository(new User());
		});
	}
}