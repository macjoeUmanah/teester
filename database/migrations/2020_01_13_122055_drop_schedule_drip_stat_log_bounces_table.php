<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropScheduleDripStatLogBouncesTable extends Migration
{
  public function up()
  {
    Schema::dropIfExists('schedule_drip_stat_log_bounces');
  }

  public function down()
  {

  }
}
