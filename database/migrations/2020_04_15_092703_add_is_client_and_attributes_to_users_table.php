<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsClientAndAttributesToUsersTable extends Migration
{
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->tinyInteger('is_client')->after('app_id')->default(0);
      $table->json('attributes')->after('is_client')->nullable();
    });
  }
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('is_client');
      $table->dropColumn('attributes');
    });
  }
}
