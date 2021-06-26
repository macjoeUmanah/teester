<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientSettingsTable extends Migration
{
  public function up()
  {
    Schema::create('client_settings', function (Blueprint $table) {
      $table->increments('id');
      $table->longText('mail_headers')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();

      $table->engine = 'InnoDB';
    });
  }
  public function down()
  {
    Schema::dropIfExists('client_settings');
  }
}
