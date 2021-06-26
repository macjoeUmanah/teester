<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldsTable extends Migration
{
  public function up()
  {
    Schema::create('custom_fields', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('tag');
      $table->enum('required', ['Yes', 'No'])->default('No');
      $table->enum('type', ['number', 'text', 'textarea', 'date', 'radio', 'checkbox', 'dropdown']);
      $table->text('values')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('custom_fields');
  }
}
