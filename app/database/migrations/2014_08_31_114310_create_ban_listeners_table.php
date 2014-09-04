<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanListenersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ban_listeners', function ($table) {
			$table->increments('id');

			$table->integer('user_id')
				->unsigned();

			$table->integer('steamid_id')
				->unsigned();

			$table->timestamps();
		});

		Schema::table('ban_listeners', function ($table) {
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('steamid_id')
				->references('id')
				->on('steamids')
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
		Schema::drop('ban_listeners');
	}

}
