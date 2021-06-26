<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSfpIpToSendingDomainsTable extends Migration
{
  public function up()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
      $table->string('spf_value', 255)->after('verification_type')->nullable();
    });
  }

  public function down()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
      $table->dropColumn('spf_value');
    });
  }
}
