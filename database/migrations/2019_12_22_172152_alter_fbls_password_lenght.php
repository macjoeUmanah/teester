<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFblsPasswordLenght extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'fbls';
    DB::statement("ALTER TABLE $table CHANGE `password` `password` VARCHAR(255) NULL DEFAULT NULL;");
  }

  public function down()
  {
    Schema::table('fbls', function (Blueprint $table) {
    });
  }
}
