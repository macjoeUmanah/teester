<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password', 255);
      $table->rememberToken();
      $table->string('api_token', 60)->unique();
      $table->enum('api', ['Enabled', 'Disabled'])->default('Enabled');
      $table->string('language', 2)->default('en');
      $table->string('address', 255)->nullable();
      $table->string('country_code', '2')->default('US');
      $table->string('phone', 25)->nullable();
      $table->string('time_zone', 100)->default('Europe/London'); // UTC
      $table->unsignedInteger('parent_id')->default(0);
      $table->unsignedInteger('app_id')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('users');
  }
}
