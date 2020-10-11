<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rates', function (Blueprint $table) {
			$table->id();
			$table->float('rate')->unsigned();
			$table->integer('pulsa')->unsigned();
			$table->integer('uang')->unsigned();
			$table->timestamps();
			$table->foreignId('provider_id')->references('id')->on('providers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('rates');
	}
}
