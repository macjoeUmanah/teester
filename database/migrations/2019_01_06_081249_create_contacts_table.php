<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
  public function up()
  {
    Schema::create('contacts', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('list_id');
      $table->string('email', 127);
      $table->enum('active', ['Yes', 'No'])->default('Yes');
      $table->enum('confirmed', ['Yes', 'No'])->default('No');
      $table->enum('unsubscribed', ['Yes', 'No'])->default('No');
      $table->enum('format', ['HTML', 'Text'])->default('text');
      $table->enum('source', ['app', 'form', 'api', 'import'])->default('app');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->unique(array('list_id', 'email'));

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('contacts');
  }
}
