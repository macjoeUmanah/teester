<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppIdToScheduleCampaignStatLogSpamsTable extends Migration
{
  public function up()
  {
    Schema::table('schedule_campaign_stat_log_spams', function (Blueprint $table) {
      $table->unsignedInteger('app_id')->default(1)->after('detail')->nullable();
    });
  }

  public function down()
  {
    Schema::table('schedule_campaign_stat_log_spams', function (Blueprint $table) {
      $table->dropColumn('app_id');
    });
  }
}
