<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnsubEmailToListsTable extends Migration
{
  public function up()
  {
      Schema::table('lists', function (Blueprint $table) {
          $table->enum('unsub_email', ['Yes', 'No'])->default('Yes')->after('welcome_email');
      });
  }

  public function down()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->dropColumn('unsub_email');
    });
  }
}
