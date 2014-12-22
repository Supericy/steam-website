<?php

use Illuminate\Database\Migrations\Migration;

class CreateBanTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ban_types', function ($table)
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
		Schema::drop('ban_types');
	}

}
