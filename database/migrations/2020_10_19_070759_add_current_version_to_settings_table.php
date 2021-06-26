<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrentVersionToSettingsTable extends Migration
{
  public function up()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->string('current_version', 20)->nullable()->after('server_ip')->default('2.4.5');
    });
  }

  public function down()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->dropColumn('current_version');
    });
  }
}
