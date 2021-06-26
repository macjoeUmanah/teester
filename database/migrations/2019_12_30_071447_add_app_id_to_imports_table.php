<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppIdToImportsTable extends Migration
{
  public function up()
  {
    Schema::table('imports', function (Blueprint $table) {
      $table->unsignedInteger('app_id')->after('user_id')->nullable();
    });
  }

  public function down()
  {
    Schema::table('imports', function (Blueprint $table) {
      $table->dropColumn('app_id');
    });
  }
}
