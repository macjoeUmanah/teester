<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropScheduleDripStatLogSpamsTable extends Migration
{
  public function up()
  {
    Schema::table('schedule_drip_stat_log_spams', function (Blueprint $table) {
        Schema::dropIfExists('schedule_drip_stat_log_spams');
    });
  }


  public function down()
  {
    Schema::table('schedule_drip_stat_log_spams', function (Blueprint $table) {
        
    });
  }
}
