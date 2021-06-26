<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerSchedules extends Migration
{

  public function up()
  {
    Schema::create('trigger_schedules', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('trigger_id');
      $table->unsignedInteger('contact_id');
      $table->timestamp('send_datetime')->nullable();
      $table->unsignedInteger('broadcast_id')->nullable();
      $table->unsignedInteger('sending_server_id')->nullable();
      $table->string('action')->nullable();
      $table->timestamps();

      $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
      $table->foreign('broadcast_id')->references('id')->on('broadcasts')->onDelete('cascade');
      $table->foreign('sending_server_id')->references('id')->on('sending_servers')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('trigger_schedules');
  }
}
