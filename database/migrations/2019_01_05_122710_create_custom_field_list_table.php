<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldListTable extends Migration
{
  public function up()
  {
    Schema::create('custom_field_list', function (Blueprint $table) {
      $table->unsignedInteger('list_id');
      $table->unsignedInteger('custom_field_id');

      $table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
      $table->foreign('custom_field_id')->references('id')->on('custom_fields')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('custom_field_list');
  }
}
