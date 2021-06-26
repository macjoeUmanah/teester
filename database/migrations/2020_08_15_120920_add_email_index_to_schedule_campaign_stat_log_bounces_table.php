<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailIndexToScheduleCampaignStatLogBouncesTable extends Migration
{

  public function up()
  {
    Schema::table('schedule_campaign_stat_log_bounces', function (Blueprint $table) {
      $table->index('email');
    });
  }
  public function down()
  {
    Schema::table('schedule_campaign_stat_log_bounces', function (Blueprint $table) {
       $table->dropIndex('schedule_campaign_stat_log_bounces_email_index');
    });
  }
}
