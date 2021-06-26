<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeySendingServerIdScheduleDrips extends Migration
{
  public function up()
  {
    Schema::table('schedule_drips', function (Blueprint $table) {
      $table->dropForeign('schedule_drips_sending_server_id_foreign');
      $table->dropIndex('schedule_drips_sending_server_id_foreign');
    });
  }

  public function down()
  {
    Schema::table('schedule_drips', function (Blueprint $table) {
      
    });
  }
}
