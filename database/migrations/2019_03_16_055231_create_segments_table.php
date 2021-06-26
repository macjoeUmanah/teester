<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSegmentsTable extends Migration
{
  public function up()
  {
    Schema::create('segments', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->enum('type', ['List', 'Campaign'])->nullable();
      $table->json('attributes')->nullable();
      $table->tinyInteger('is_running')->default(0);
      $table->enum('action', ['Copy', 'Move', 'Export', 'Suppress'])->nullable();
      $table->unsignedInteger('total')->default(0);
      $table->unsignedInteger('processed')->default(0);
      $table->unsignedInteger('list_id_action')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('segments');
  }
}
