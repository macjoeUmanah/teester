<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPmtaToBouncesTable extends Migration
{
  public function up()
  {
    Schema::table('bounces', function (Blueprint $table) {
      $table->unsignedInteger('pmta')->after('user_id')->nullable();
    });
  }

  public function down()
  {
    Schema::table('bounces', function (Blueprint $table) {
      $table->dropColumn('pmta');
    });
  }
}
