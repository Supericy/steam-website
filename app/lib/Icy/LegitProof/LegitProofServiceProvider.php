<?php namespace Icy\LegitProof;

use Illuminate\Support\ServiceProvider;

/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 10/6/2014
 * Time: 4:21 PM
 */
class LegitProofServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Icy\LegitProof\ILeagueExperienceRepository', function ($app)
		{
			return $app->make('Icy\LegitProof\LeagueExperienceRepository');
		});

		$this->app->bind('Icy\LegitProof\ILegitProof', function ($app)
		{
			return $app->make('Icy\LegitProof\LegitProof');
		});
	}

} 