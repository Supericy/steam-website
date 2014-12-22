<?php

use Illuminate\Database\Migrations\Migration;

class CreateOauthProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_providers', function ($table)
		{
			$table->increments('id');
			$table->string('name')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_providers');
	}

}
