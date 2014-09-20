<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auth_tokens', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')
				->unsigned();
			$table->string('token', 100);
			$table->timestamps();
		});

		Schema::table('auth_tokens', function ($table) {
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auth_tokens');
	}

}
