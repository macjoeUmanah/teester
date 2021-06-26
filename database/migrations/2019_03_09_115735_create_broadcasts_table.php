<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBroadcastsTable extends Migration
{
  public function up()
  {
    Schema::create('broadcasts', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->unsignedInteger('group_id')->nullable();
      $table->string('email_subject');
      $table->longText('content_html')->nullable();
      $table->longText('content_text')->nullable();
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
    Schema::dropIfExists('broadcasts');
  }
}
