<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleCampaignStatLogsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_campaign_stat_logs', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_campaign_stat_id')->nullable();
      $table->string('message_id')->nullable();
      $table->string('email')->nullable();
      $table->string('list')->nullable();
      $table->string('broadcast')->nullable();
      $table->string('sending_server')->nullable();
      $table->enum('status', ['Sent', 'Failed', 'Unsubscribed', 'Opened', 'Clicked', 'Bounced', 'Spammed'])->default('Sent');
      $table->timestamps();

      $table->foreign('schedule_campaign_stat_id', 'scsl_id_scs_id')->references('id')->on('schedule_campaign_stats')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_campaign_stat_logs');
  }
}
