<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeneralSettingsToSettingsTable extends Migration
{
  public function up()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->json('general_settings')->nullable()->after('attributes');
    });
  }

  public function down()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->dropColumn('general_settings');
    });
  }
}
