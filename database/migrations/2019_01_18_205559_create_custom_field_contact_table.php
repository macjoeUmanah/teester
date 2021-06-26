<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldContactTable extends Migration
{
  public function up()
  {
    Schema::create('custom_field_contact', function (Blueprint $table) {
      $table->unsignedInteger('contact_id');
      $table->unsignedInteger('custom_field_id');
      $table->text('data')->nullable();

      $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
      $table->foreign('custom_field_id')->references('id')->on('custom_fields')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('custom_field_contact');
  }
}
