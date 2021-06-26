<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
  public function up()
  {
    Schema::create('imports', function (Blueprint $table) {
      $table->increments('id');
      $table->enum('type', ['contact', 'suppression'])->nullable();
      $table->string('file');
      $table->json('attributes')->nullable();
      $table->unsignedInteger('total');
      $table->unsignedInteger('processed')->default(0);
      $table->unsignedInteger('duplicates')->default(0);
      $table->unsignedInteger('invalids')->default(0);
      $table->unsignedInteger('user_id');
      $table->timestamp('created_at')->useCurrent();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('imports');
  }
}
