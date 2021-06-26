<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersTable extends Migration
{

  public function up()
  {
    Schema::create('triggers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('based_on');
      $table->string('action');
      $table->text('sending_server_ids')->nullable();
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->longText('attributes')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('triggers');
  }
}
