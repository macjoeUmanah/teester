<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerifiedDmarcToSendingDomainsTable extends Migration
{

  public function up()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
      $table->unsignedTinyInteger('verified_dmarc')->after('verified_spf')->default(0);
    });
  }

  public function down()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
      $table->dropColumn('verified_dmarc');
    });
  }
}
