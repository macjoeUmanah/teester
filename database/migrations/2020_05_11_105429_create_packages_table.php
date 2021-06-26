<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
  public function up()
  {
    Schema::create('packages', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 255)->nullable();
      $table->mediumText('description')->nullable();
      $table->json('attributes')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('packages');
  }
}
