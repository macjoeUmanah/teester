<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectionToScheduleCampaignStatLogSpams extends Migration
{
  public function up()
  {
    Schema::table('schedule_campaign_stat_log_spams', function (Blueprint $table) {
      $table->enum('section', ['Campaign', 'Drip', 'AutoFollowup', 'SplitTest', 'Add', 'Other'])->after('schedule_campaign_stat_log_id')->default('Campaign');
    });
  }

  public function down()
  {
    Schema::table('schedule_campaign_stat_log_spams', function (Blueprint $table) {
      $table->dropColumn('section');
    });
  }
}
