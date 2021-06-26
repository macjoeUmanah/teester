<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDripsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_drips', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('drip_group_id')->nullable();
      $table->string('list_ids')->nullable();
      $table->unsignedInteger('sending_server_id')->nullable();
      $table->enum('send_to_existing', ['Yes', 'No'])->default('Yes');
      $table->enum('status', ['Running', 'Paused'])->default('Running');
      $table->boolean('in_progress')->default(false);
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('drip_group_id')->references('id')->on('groups');
      $table->foreign('sending_server_id')->references('id')->on('sending_servers');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_drips');
  }
}
