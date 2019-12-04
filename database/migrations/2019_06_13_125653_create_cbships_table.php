<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cbships', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('cartonbox')->unique();
			$table->string('po');
			$table->string('style');
			$table->string('color');
			$table->string('size');
			$table->integer('qty');
			$table->integer('standard_qty')->nullable();
			$table->dateTime('boxclosed')->nullable();

			$table->string('module')->nullable();

			$table->string('pallet')->nullable();
			$table->string('coment')->nullable();
			
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
		Schema::drop('cbships');
	}

}
