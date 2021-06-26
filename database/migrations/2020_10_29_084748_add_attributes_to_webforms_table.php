<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesToWebformsTable extends Migration
{
  public function up()
  {
    Schema::table('webforms', function (Blueprint $table) {
      $table->longText('attributes')->nullable()->after('custom_field_ids');
    });
  }


  public function down()
  {
    Schema::table('webforms', function (Blueprint $table) {
      $table->dropColumn('attributes');
    });
  }
}
