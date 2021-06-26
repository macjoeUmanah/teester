<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleidToUsersTable extends Migration
{
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->unsignedInteger('role_id')->after('time_zone');
    });
  }

  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('role_id');
    });
  }
}
