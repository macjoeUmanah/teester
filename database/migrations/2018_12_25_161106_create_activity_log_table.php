<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
  public function up()
  {
    Schema::create(config('activitylog.table_name'), function (Blueprint $table) {
      $table->increments('id');
      $table->string('log_name')->nullable();
      $table->text('description')->nullable();
      $table->integer('subject_id')->nullable();
      $table->string('subject_type')->nullable();
      $table->integer('causer_id')->nullable();
      $table->string('causer_type')->nullable();
      $table->text('properties')->nullable();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists(config('activitylog.table_name'));
  }
}
