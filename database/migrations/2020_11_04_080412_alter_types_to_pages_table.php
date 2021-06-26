<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTypesToPagesTable extends Migration
{

  public function up()
  {
    $table = DB::getTablePrefix(). 'pages';
    DB::statement("ALTER TABLE $table CHANGE `type` `type` ENUM('Email', 'Notification', 'Page') default 'Page';");
    DB::statement("UPDATE $table SET `type` = 'Notification' WHERE slug like 'notify-%'");
  }

  public function down()
  {
    Schema::table('pages', function (Blueprint $table) {
      //
    });
  }
}
