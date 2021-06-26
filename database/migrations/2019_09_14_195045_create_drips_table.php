<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDripsTable extends Migration
{
  public function up()
  {
    Schema::create('drips', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('group_id')->nullable();
      $table->unsignedInteger('broadcast_id')->nullable();
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->enum('send', ['Instant', 'After'])->default('Instant');
      $table->unsignedInteger('after_minutes')->nullable();
      $table->json('send_attributes')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('group_id')->references('id')->on('groups');
      $table->foreign('broadcast_id')->references('id')->on('broadcasts')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('drips');
  }
}
