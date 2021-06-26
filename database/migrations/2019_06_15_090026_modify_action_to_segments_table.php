<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyActionToSegmentsTable extends Migration
{
  public function up()
  {
    //$table = DB::getTablePrefix(). 'segments';
    //DB::statement("ALTER TABLE $table CHANGE `action` `action` ENUM('None', 'Copy', 'Move', 'Export', 'Suppress') default 'None';");
  }

  public function down()
  {
    //$table = DB::getTablePrefix(). 'segments';
    //DB::statement("ALTER TABLE $table CHANGE `action` `action` ENUM('Copy', 'Move', 'Export', 'Suppress') default NULL;");
  }
}
