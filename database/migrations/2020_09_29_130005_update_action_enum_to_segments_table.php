<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActionEnumToSegmentsTable extends Migration
{
  public function up()
  {
    Schema::table('segments', function (Blueprint $table) {
      $table = DB::getTablePrefix(). 'segments';
      DB::statement("ALTER TABLE $table CHANGE `action` `action` ENUM('Copy', 'Move', 'Export', 'Suppress', 'Keep Copying', 'Keep Moving') default NULL;");
    });
  }

  public function down()
  {
    Schema::table('segments', function (Blueprint $table) {
      //
    });
  }
}
