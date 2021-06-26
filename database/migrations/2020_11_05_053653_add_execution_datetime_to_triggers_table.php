<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExecutionDatetimeToTriggersTable extends Migration
{
  public function up()
  {
    Schema::table('triggers', function (Blueprint $table) {
      $table->timestamp('execution_datetime')->useCurrent()->after('in_progress');
    });
  }

  public function down()
  {
    Schema::table('triggers', function (Blueprint $table) {
      $table->dropColumn('execution_datetime');
    });
  }
}
