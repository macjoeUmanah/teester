<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToTemplatesTable extends Migration
{
  public function up()
  {
    Schema::table('templates', function (Blueprint $table) {
      $table->unsignedTinyInteger('type')->after('content')->default(1);
    });
  }

  public function down()
  {
    Schema::table('templates', function (Blueprint $table) {
      $table->dropColumn('package_id');
    });
  }
}
