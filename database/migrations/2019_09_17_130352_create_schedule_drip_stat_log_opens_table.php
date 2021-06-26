<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDripStatLogOpensTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_drip_stat_log_opens', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('schedule_drip_stat_log_id')->nullable();
      $table->string('ip')->nullable();
      $table->string('country')->nullable();
      $table->char('country_code', 2)->nullable();
      $table->string('city')->nullable();
      $table->string('zipcode')->nullable();
      $table->string('user_agent')->nullable();
      $table->timestamp('created_at')->useCurrent();

      $table->foreign('schedule_drip_stat_log_id', 'sdslo_id_scs_id')->references('id')->on('schedule_drip_stat_logs')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_drip_stat_log_opens');
  }
}
