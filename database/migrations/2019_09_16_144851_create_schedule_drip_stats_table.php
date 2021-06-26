<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDripStatsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_drip_stats', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_drip_id')->nullable();
      $table->string('schedule_by')->nullable();
      $table->string('schedule_drip_name')->nullable();
      $table->string('drip_group_name')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::table('schedule_drip_stats', function (Blueprint $table) {
      Schema::dropIfExists('schedule_drip_stats');
    });
  }
}
