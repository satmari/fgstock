<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellRmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sell_rms', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('item');
			$table->string('variant');
			$table->double('qty');
			$table->string('applay');

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
		Schema::drop('sell_rms');
	}

}


/*

  [Item No_]
      ,[Variant Code]
      ,[Location Code]
      ,[Global Dimension 1 Code] as CC
      ,[Remaining Quantity] as Qty
      ,[Remaining Quantity] as QtyShip
      ,[Remaining Quantity] as QtyInv
      ,[Entry No_] as Applay_to_entry

      */