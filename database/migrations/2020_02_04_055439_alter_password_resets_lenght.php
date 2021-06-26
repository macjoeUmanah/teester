<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPasswordResetsLenght extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'password_resets';
    DB::statement("ALTER TABLE $table CHANGE `token` `token` VARCHAR(255) NULL DEFAULT NULL;");
  }

  public function down()
  {
    Schema::table('password_resets', function (Blueprint $table) {
    });
  }
}
