<?php

use Illuminate\Database\Migrations\Migration;

class CreateEseaBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('esea_bans', function ($table)
		{
			$table->bigInteger('steam_id');
			$table->string('alias', 64);

			$table->string('first_name', 64);
			$table->string('last_name', 64);

			$table->timestamp('timestamp');

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
		Schema::drop('esea_bans');
	}

}
