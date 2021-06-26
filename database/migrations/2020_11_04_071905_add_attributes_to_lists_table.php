<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesToListsTable extends Migration
{
  public function up()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->longText('attributes')->nullable()->after('notification_attributes');
    });
  }

  public function down()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->dropColumn('attributes');
    });
  }
}
