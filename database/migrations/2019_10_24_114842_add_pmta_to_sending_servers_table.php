<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPmtaToSendingServersTable extends Migration
{
  public function up()
  {
    Schema::table('sending_servers', function (Blueprint $table) {
      $table->unsignedInteger('pmta')->nullable();
    });
  }

  public function down()
  {
    Schema::table('sending_servers', function (Blueprint $table) {
      $table->dropColumn('pmta');
    });
  }
}
