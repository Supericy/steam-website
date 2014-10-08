<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ban_notifications', function ($table) {

			$table->increments('id');

			$table->integer('favourite_id')
				->unsigned();

			$table->boolean('enabled');

			$table->timestamps();

		});

		Schema::table('ban_notifications', function ($table) {

			$table->foreign('favourite_id')
				->references('id')
				->on('favourites')
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
		Schema::drop('ban_notifications');
	}

}
