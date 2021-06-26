<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendingServersTable extends Migration
{
  public function up()
  {
    Schema::create('sending_servers', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('group_id')->nullable();
      $table->string('name');
      $table->enum('type', ['php_mail', 'smtp', 'amazon_ses_api', 'mailgun_api', 'mandrill_api', 'sparkpost_api', 'sendgrid_api'])->default('smtp');
      $table->enum('status', ['Active', 'Inactive', 'System Inactive', 'System Paused'])->default('Active');
      $table->text('notification')->nullable();
      $table->string('from_name')->nullable();
      $table->string('from_email')->nullable();
      $table->string('reply_email')->nullable();
      $table->unsignedInteger('bounce_id')->nullable();
      $table->json('sending_attributes')->nullable();
      $table->json('speed_attributes')->nullable();
      $table->unsignedInteger('total_sent')->default(0);
      $table->unsignedInteger('hourly_sent')->default(0);
      $table->timestamp('hourly_sent_next_timestamp')->nullable();
      $table->unsignedInteger('daily_sent')->default(0);
      $table->timestamp('daily_sent_next_timestamp')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('sending_servers');
  }
}
