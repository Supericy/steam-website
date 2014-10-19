<?php

use Illuminate\Database\Migrations\Migration;

class AddBanTypeColumnToBanDetections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ban_detections', function ($table)
		{

			$table->dropColumn('new_vac_status');

			$table->integer('ban_type_id')
				->unsigned()
				->before('created_at');

			$table->boolean('ban_status')
				->after('ban_type_id');

		});

		Schema::table('ban_detections', function ($table)
		{

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
		//
	}

}
