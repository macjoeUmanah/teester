<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlacklistedsTable extends Migration
{
  public function up()
  {
    Schema::create('blacklisteds', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 255)->nullable();
      $table->enum('ip_domain', ['ip', 'domain'])->default('ip');
      $table->longText('detail')->nullable();
      $table->unsignedInteger('counts');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamp('created_at');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('blacklisteds');
  }
}
