<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListsTable extends Migration
{
  public function up()
  {
    Schema::create('lists', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('group_id')->nullable();
      $table->enum('double_optin', ['Yes', 'No'])->default('No');
      $table->enum('welcome_email', ['Yes', 'No'])->default('No');
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('lists');
  }
}
