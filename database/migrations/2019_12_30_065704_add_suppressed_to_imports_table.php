<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuppressedToImportsTable extends Migration
{
  public function up()
  {
    Schema::table('imports', function (Blueprint $table) {
      $table->unsignedInteger('suppressed')->after('invalids')->default(0);
    });
  }

  public function down()
  {
    Schema::table('imports', function (Blueprint $table) {
      $table->dropColumn('suppressed');
    });
  }
}
