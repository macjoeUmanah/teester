<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFroeignKeyScheduleCampaignStatLogBounces extends Migration
{
  public function up()
  {
    Schema::table('schedule_campaign_stat_log_bounces', function (Blueprint $table) {
      $table->dropForeign('scslb_id_scs_id');
      $table->dropIndex('scslb_scslid_unique');
    });
  }

  public function down()
  {
    Schema::table('schedule_campaign_stat_log_bounces', function (Blueprint $table) {
      //$table->foreign('schedule_campaign_stat_log_id', 'scslb_id_scs_id')->references('id')->on('schedule_campaign_stat_logs')->onDelete('cascade');
    });
  }
}
