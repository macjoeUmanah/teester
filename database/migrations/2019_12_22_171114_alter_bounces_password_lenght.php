<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBouncesPasswordLenght extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'bounces';
    DB::statement("ALTER TABLE $table CHANGE `password` `password` VARCHAR(255) NULL DEFAULT NULL;");
  }

  public function down()
  {
    Schema::table('bounces', function (Blueprint $table) {
    });
  }
}
