<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationAttributesToListsTable extends Migration
{
  public function up()
  {
    Schema::table('lists', function (Blueprint $table) {
        $table->json('notification_attributes')->nullable()->after('notification');
    });
  }

  public function down()
  {
    Schema::table('lists', function (Blueprint $table) {
        $table->dropColumn('notification_attributes');
    });
  }
}
