<?php

use Illuminate\Database\Migrations\Migration;

class AddDaysSinceLastBanColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('steamids', function ($table)
		{

			$table->integer('days_since_last_ban')
				->nullable()
				->default(null);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('steamids', function ($table)
		{

			$table->dropColumn('days_since_last_ban');

		});
	}

}
