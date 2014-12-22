<?php

use Illuminate\Database\Migrations\Migration;

class CreateOauthAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_accounts', function ($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('provider_id')->unsigned();
			$table->string('account_id');

			$table->timestamps();
		});

		Schema::table('oauth_accounts', function ($table)
		{

			$table->foreign('user_id')
				->references('id')
				->on('users');

			$table->foreign('provider_id')
				->references('id')
				->on('oauth_providers');

			$table->unique(['user_id', 'provider_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_accounts');
	}

}
