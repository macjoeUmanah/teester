<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendDatetimeToDripsTable extends Migration
{

  public function up()
  {
    Schema::table('drips', function (Blueprint $table) {
      $table->timestamp('send_datetime')->useCurrent()->after('send_attributes');
    });
  }

  public function down()
  {
    Schema::table('drips', function (Blueprint $table) {
      $table->dropColumn('send_datetime');
    });
  }
}
