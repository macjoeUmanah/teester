<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeySendingServerIdAutoFollowups extends Migration
{

  public function up()
  {
    Schema::table('auto_followups', function (Blueprint $table) {
      $table->dropForeign('auto_followups_sending_server_id_foreign');
      $table->dropIndex('auto_followups_sending_server_id_foreign');
    });
  }

  public function down()
  {
    Schema::table('auto_followups', function (Blueprint $table) {
      
    });
  }
}
