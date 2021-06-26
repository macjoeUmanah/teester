<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationToListsTable extends Migration
{
  public function up()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->enum('notification', ['Disabled', 'Enabled'])->default('Disabled')->after('welcome_email');
    });
  }

  public function down()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->dropColumn('notification');
    });
  }
}
