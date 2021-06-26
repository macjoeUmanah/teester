<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAutoFollowupStatLogBouncesTable extends Migration
{

  public function up()
  {
    Schema::dropIfExists('auto_followup_stat_log_bounces');
  }

  public function down()
  {
    //
  }
}
