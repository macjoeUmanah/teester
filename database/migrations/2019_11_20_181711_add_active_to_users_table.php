<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToUsersTable extends Migration
{
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->enum('active', ['Yes', 'No'])->after('app_id')->default('Yes');
    });
  }

  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('active');
    });
  }
}
