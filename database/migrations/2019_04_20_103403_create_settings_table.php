<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
  public function up()
  {
    Schema::create('settings', function (Blueprint $table) {
      $table->increments('id');
      $table->string('app_name')->nullable();
      $table->string('app_url')->nullable();
      $table->string('license_key')->nullable();
      $table->string('server_ip')->nullable();
      $table->string('time_zone', 100)->default('Europe/London'); // UTC
      $table->enum('tracking', ['enabled', 'disabled'])->default('enabled');
      $table->string('from_email')->nullable();
      $table->enum('sending_type', ['php_mail', 'smtp', 'amazon_ses_api', 'mailgun_api', 'sparkpost_api', 'sendgrid_api', 'mandrill_api'])->default('php_mail');
      $table->json('sending_attributes')->nullable();
      $table->json('attributes')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('settings');
  }
}
