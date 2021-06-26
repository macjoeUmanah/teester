<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
  public function up()
  {
    Schema::create('pages', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('slug')->nullable();
      $table->enum('type', ['Page', 'Email'])->default('Page');
      $table->text('email_subject')->nullable();
      $table->longText('content_html')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('pages');
  }
}
