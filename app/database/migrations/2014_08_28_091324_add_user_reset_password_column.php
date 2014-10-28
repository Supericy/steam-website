<?php

use Illuminate\Database\Migrations\Migration;

class AddUserResetPasswordColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function ($table)
		{
			$table->string('reset_token', 100)
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
		Schema::table('users', function ($table)
		{
			$table->dropColumn('reset_token');
		});
	}

}
