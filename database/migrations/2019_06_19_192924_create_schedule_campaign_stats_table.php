<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleCampaignStatsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_campaign_stats', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_campaign_id')->nullable();
      $table->string('schedule_campaign_name')->nullable();
      $table->string('schedule_by')->nullable();
      $table->unsignedTinyInteger('threads')->default(5);
      $table->unsignedInteger('total')->nullable();
      $table->unsignedInteger('scheduled')->nullable();
      $table->unsignedInteger('sent')->nullable();
      $table->json('scheduled_detail')->nullable();
      $table->json('sending_speed')->nullable();
      $table->timestamp('start_datetime')->nullable();
      $table->timestamp('end_datetime')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_campaign_stats');
  }
}
