<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEseaBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('esea_bans', function ($table) {

			$table->increments('id');

			$table->string('steamid', 32);

			$table->string('alias', 64);
			$table->string('firstname', 64);
			$table->string('lastname', 64);

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
