<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendingServerIdToListsTable extends Migration
{
  public function up()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->unsignedInteger('sending_server_id')->after('group_id')->nullable();
      $table->foreign('sending_server_id')->references('id')->on('sending_servers');
    });
  }

  public function down()
  {
    Schema::table('lists', function (Blueprint $table) {
      $table->dropForeign(['sending_server_id']);
      $table->dropColumn('sending_server_id');
    });
  }
}
