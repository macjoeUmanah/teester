<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFblsTable extends Migration
{
  public function up()
  {
    Schema::create('fbls', function (Blueprint $table) {
      $table->increments('id');
      $table->string('email');
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->enum('method', ['imap', 'pop3'])->default('imap');
      $table->string('host')->nullable();
      $table->string('username')->nullable();
      $table->string('password', 255)->nullable();
      $table->unsignedSmallInteger('port')->nullable();
      $table->enum('encryption', ['ssl', 'tls', 'none'])->default('ssl');
      $table->enum('validate_cert', ['Yes', 'No'])->default('Yes');
      $table->enum('delete_after_processing', ['Yes', 'No'])->default('No');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('fbls');
  }
}
