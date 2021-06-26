<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendingDomains extends Migration
{
  public function up()
  {
    Schema::create('sending_domains', function (Blueprint $table) {
      $table->increments('id');
      $table->string('domain');
      $table->enum('protocol', ['http://', 'https://'])->default('https://');
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->enum('signing', ['Yes', 'No'])->default('No');
      $table->text('public_key')->nullable();
      $table->text('private_key')->nullable();
      $table->unsignedTinyInteger('verified_domain')->default(0);
      $table->unsignedTinyInteger('verified_key')->default(0);
      $table->unsignedTinyInteger('verified_spf')->default(0);
      $table->unsignedTinyInteger('verified_tracking')->default(0);
      $table->string('tracking', 50)->default('track')->nullable();
      $table->enum('verification_type', ['CNAME', 'htaccess'])->default('CNAME');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('sending_domains');
  }
}
