<?php

use Illuminate\Database\Migrations\Migration;

class CreateBanLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ban_detections', function ($table)
		{

			$table->increments('id');
			$table->integer('steamid_id')
				->unsigned();

			$table->boolean('new_vac_status');
			$table->timestamps();
		});

		Schema::table('ban_detections', function ($table)
		{

			$table->foreign('steamid_id')
				->references('id')
				->on('steamids');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ban_detections');
	}

}
