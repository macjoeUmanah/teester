<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoFollowupStats extends Migration
{

  public function up()
  {
    Schema::create('auto_followup_stats', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('auto_followup_id')->nullable();
      $table->string('auto_followup_name')->nullable();
      $table->string('schedule_by')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('auto_followup_stats');
  }
}
