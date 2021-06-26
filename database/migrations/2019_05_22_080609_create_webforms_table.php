<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebformsTable extends Migration
{
  public function up()
  {
    Schema::create('webforms', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->enum('duplicates', ['Skip', 'Overwrite'])->default('Skip');
      $table->unsignedInteger('list_id')->nullable();
      $table->string('custom_field_ids')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('webforms');
  }
}
