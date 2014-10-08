<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivationCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activation_codes', function ($table) {

			$table->increments('id');

			$table->integer('user_id')
				->unsigned();

			$table->char('code', 16);

			$table->timestamps();
		});

		Schema::table('activation_codes', function ($table) {

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->unique('code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activation_codes');
	}

}
