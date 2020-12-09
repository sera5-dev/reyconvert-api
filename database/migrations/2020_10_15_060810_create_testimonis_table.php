<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('testimonis', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->string('kontak');
      $table->string('komentar');
      $table->string('gambar')->nullable();
      $table->string('video')->nullable();
      $table->integer('star');
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
    Schema::dropIfExists('testimonis');
  }
}
