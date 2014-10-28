<?php

use Illuminate\Database\Migrations\Migration;

class AddActivationCodeColumnToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function ($table)
		{

			$table->char('activation_code', 16)
				->nullable();

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
