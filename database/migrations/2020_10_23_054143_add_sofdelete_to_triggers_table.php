<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSofdeleteToTriggersTable extends Migration
{


  public function up()
  {
    Schema::table('triggers', function (Blueprint $table) {
      $table->boolean('in_progress')->default(false)->after('attributes');
      $table->softDeletes();
    });
  }


  public function down()
  {
    Schema::table('triggers', function (Blueprint $table) {
      $table->dropColumn('in_progress');
      $table->dropSoftDeletes();
    });
  }
}
