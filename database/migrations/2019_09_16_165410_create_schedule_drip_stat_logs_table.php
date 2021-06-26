<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDripStatLogsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_drip_stat_logs', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_drip_stat_id')->nullable();
      $table->unsignedInteger('drip_id')->nullable();
      $table->string('drip_name')->nullable();
      $table->string('message_id')->nullable();
      $table->string('email')->nullable();
      $table->string('list')->nullable();
      $table->string('broadcast')->nullable();
      $table->string('sending_server')->nullable();
      $table->enum('status', ['Sent', 'Failed', 'Unsubscribed', 'Opened', 'Clicked', 'Bounced', 'Spammed'])->default('Sent');
      $table->timestamps();

      $table->foreign('schedule_drip_stat_id', 'sdsl_id_scs_id')->references('id')->on('schedule_drip_stats')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_drip_stat_logs');
  }
}
