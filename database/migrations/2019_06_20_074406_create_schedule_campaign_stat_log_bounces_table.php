<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleCampaignStatLogBouncesTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_campaign_stat_log_bounces', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_campaign_stat_log_id')->unique('scslb_scslid_unique');
      $table->string('email')->nullable();
      $table->enum('type', ['Soft', 'Hard'])->default('Soft');
      $table->string('code')->nullable();
      $table->json('detail')->nullable();
      $table->timestamp('created_at')->useCurrent();

      $table->foreign('schedule_campaign_stat_log_id', 'scslb_id_scs_id')->references('id')->on('schedule_campaign_stat_logs')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_campaign_stat_log_bounces');
  }
}
