<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHandledColumnToBanDetections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ban_detections', function ($table)
		{

			$table->boolean('handled')
				->default(false)
				->after('ban_status');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ban_detections', function ($table)
		{
			$table->dropColumn('handled');
		});
	}

}
