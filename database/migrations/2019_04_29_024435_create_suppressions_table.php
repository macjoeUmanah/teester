<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppressionsTable extends Migration
{
  public function up()
  {
    Schema::create('suppressions', function (Blueprint $table) {
      $table->increments('id');
      $table->string('email')->nullable();
      $table->unsignedInteger('group_id')->nullable();
      $table->unsignedInteger('list_id')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('suppressions');
  }
}
