<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAutoFollowupStatLogSpamsTable extends Migration
{

  public function up()
  {
    Schema::table('auto_followup_stat_log_spams', function (Blueprint $table) {
      Schema::dropIfExists('auto_followup_stat_log_spams');
    });
  }

  public function down()
  {
    Schema::table('auto_followup_stat_log_spams', function (Blueprint $table) {
      //
    });
  }
}
