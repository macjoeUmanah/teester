<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileOffsetsTable extends Migration
{
  public function up()
  {
    Schema::create('file_offsets', function (Blueprint $table) {
      $table->increments('id');
      $table->text('file')->nullable();
      $table->unsignedInteger('offset')->nullable();
      $table->timestamp('created_at')->useCurrent();
    });
  }

  public function down()
  {
    Schema::dropIfExists('file_offsets');
  }
}
