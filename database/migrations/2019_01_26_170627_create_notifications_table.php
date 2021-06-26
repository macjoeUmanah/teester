<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
  public function up()
  {
    Schema::create('notifications', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name')->nullable();
      $table->enum('type', ['import', 'export', 'copy', 'move', 'total', 'update', 'other'])->nullable();
      $table->unsignedTinyInteger('is_read')->default(0);
      $table->json('attributes')->nullable();
      $table->unsignedInteger('app_id')->nullable();
      $table->unsignedInteger('user_id')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('notifications');
  }
}
