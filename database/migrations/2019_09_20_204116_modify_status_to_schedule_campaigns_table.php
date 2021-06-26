<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStatusToScheduleCampaignsTable extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'schedule_campaigns';
    DB::statement("ALTER TABLE $table CHANGE `status` `status` ENUM('Preparing', 'Scheduled', 'Running', 'RunningLimit', 'Paused', 'Resume', 'System Paused', 'Completed') default 'Preparing';");
  }

  public function down()
  {
    $table = DB::getTablePrefix(). 'schedule_campaigns';
    DB::statement("ALTER TABLE $table CHANGE `status` `status` ENUM('Preparing', 'Scheduled', 'Running', 'RunningLimit', 'Paused', 'System Paused', 'Completed') default 'Preparing';");
  }
}
