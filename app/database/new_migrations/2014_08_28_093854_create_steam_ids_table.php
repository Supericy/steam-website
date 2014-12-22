<?php

use Illuminate\Database\Migrations\Migration;

class CreateSteamidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('steam_ids', function ($table)
		{
			$table->bigInteger('steam_id')->unique();
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
		Schema::drop('steamids');
	}

}
