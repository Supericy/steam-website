<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_experiences', function ($table) {

			$table->increments('id');

			$table->string('steamid', 32);
			$table->string('player');
			$table->string('team');
			$table->string('league');
			$table->string('division');
			$table->integer('join');
			$table->integer('leave');

			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('league_experiences');
	}

}
