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
		Schema::create('steamids', function ($table)
		{
			$table->increments('id');
			$table->string('steamid', 32)
				->unique();

			$table->boolean('vac_banned')
				->default(0);

			$table->boolean('changed')
				->default(0);

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
