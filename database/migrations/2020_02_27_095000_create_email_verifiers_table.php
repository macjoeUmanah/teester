<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailVerifiersTable extends Migration
{
  public function up()
  {
    Schema::create('email_verifiers', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->nullable();
      $table->json('attributes')->nullable();
      $table->unsignedInteger('total_verified')->default(0);
      $table->string('type')->nullable()->default('kickbox');
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });
  }
  public function down()
  {
    Schema::dropIfExists('email_verifiers');
  }
}
