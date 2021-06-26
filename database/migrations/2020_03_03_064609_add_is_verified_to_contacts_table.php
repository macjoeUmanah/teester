<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsVerifiedToContactsTable extends Migration
{
  public function up()
  {
    Schema::table('contacts', function (Blueprint $table) {
      $table->enum('verified', ['Yes', 'No'])->default('No')->after('format');
    });
  }

  public function down()
  {
    Schema::table('contacts', function (Blueprint $table) {
      $table->dropColumn('verified');
    });
  }
}
