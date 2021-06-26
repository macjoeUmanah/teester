<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerLogsTable extends Migration
{

  public function up()
  {
    Schema::create('trigger_logs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('trigger_id');
      $table->dateTime('created_at')->useCurrent();
    });
  }

  public function down()
  {
    Schema::dropIfExists('trigger_logs');
  }
}
