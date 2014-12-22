<?php

use Illuminate\Database\Migrations\Migration;

class CreateLeagueExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_experiences', function ($table)
		{
			$table->bigInteger('steam_id');
			$table->string('guid');
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
