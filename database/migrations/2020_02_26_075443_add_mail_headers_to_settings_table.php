<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMailHeadersToSettingsTable extends Migration
{
  public function up()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->longText('mail_headers')->nullable()->after('attributes');
    });
  }
  public function down()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->dropColumn('mail_headers');
    });
  }
}