<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CcreateMessagesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('messages', function (Blueprint $table)
		{

			$table->increments('id');
			$table->integer('from', false, true);
			$table->string('subject');
			$table->text('body');
			$table->integer('to', false, true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::drop('messages');
	}
}
