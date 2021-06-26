<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPmtaToSettingsTable extends Migration
{
  public function up()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->json('pmta')->after('attributes')->nullable();
    });
  }

  public function down()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->dropColumn('pmta');
    });
  }
}
