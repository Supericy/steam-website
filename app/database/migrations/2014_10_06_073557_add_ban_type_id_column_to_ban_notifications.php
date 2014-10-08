<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBanTypeIdColumnToBanNotifications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ban_notifications', function ($table) {

			$table->integer('ban_type_id')
				->unsigned()
				->after('favourite_id');

		});

		Schema::table('ban_notifications', function ($table) {

			$table->foreign('ban_type_id')
				->references('id')
				->on('ban_types');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ban_notifications', function ($table) {

			$table->dropColumn('ban_type_id');

		});
	}

}
