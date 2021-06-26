<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleCampaignsTable extends Migration
{
  public function up()
  {
    Schema::create('schedule_campaigns', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('broadcast_id')->nullable();
      $table->string('list_ids')->nullable();
      $table->string('sending_server_ids')->nullable();
      $table->enum('send', ['now', 'later'])->default('now');
      $table->timestamp('send_datetime')->useCurrent();
      $table->json('sending_speed')->nullable();
      $table->unsignedTinyInteger('threads')->default(5);
      $table->unsignedTinyInteger('thread_no')->default(0);
      $table->unsignedInteger('total_threads')->nullable();
      $table->unsignedInteger('total')->nullable();
      $table->unsignedInteger('scheduled')->nullable();
      $table->unsignedInteger('sent')->nullable();
      $table->json('scheduled_detail')->nullable();
      $table->enum('status', ['Preparing', 'Scheduled', 'Running', 'RunningLimit', 'Paused', 'System Paused', 'Completed'])->default('Preparing');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('broadcast_id')->references('id')->on('broadcasts')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('schedule_campaigns');
  }
}
