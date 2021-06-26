<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoFollowupStatLogs extends Migration
{
  public function up()
  {
    Schema::create('auto_followup_stat_logs', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('auto_followup_stat_id')->nullable();
      $table->string('message_id')->nullable();
      $table->string('email')->nullable();
      $table->string('list')->nullable();
      $table->string('broadcast')->nullable();
      $table->string('sending_server')->nullable();
      $table->enum('status', ['Sent', 'Failed', 'Unsubscribed', 'Opened', 'Clicked', 'Bounced', 'Spammed'])->default('Sent');
      $table->timestamps();

      $table->foreign('auto_followup_stat_id', 'afsl_id_afs_id')->references('id')->on('auto_followup_stats')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('auto_followup_stat_logs');
  }
}
