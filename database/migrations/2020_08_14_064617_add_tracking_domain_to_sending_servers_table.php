<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingDomainToSendingServersTable extends Migration
{

  public function up()
  {
    Schema::table('sending_servers', function (Blueprint $table) {
      $table->string('tracking_domain', 255)->nullable()->after('reply_email');
    });
  }

  public function down()
  {
    Schema::table('sending_servers', function (Blueprint $table) {
      $table->dropColumn('tracking_domain');
    });
  }
}
