<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoFollowupsTable extends Migration
{
  public function up()
  {
    Schema::create('auto_followups', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('segment_id')->nullable();
      $table->unsignedInteger('broadcast_id')->nullable();
      $table->unsignedInteger('sending_server_id')->nullable();
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('broadcast_id')->references('id')->on('broadcasts')->onDelete('cascade');
      $table->foreign('sending_server_id')->references('id')->on('sending_servers');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('auto_followups');
  }
}
