<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDkimDmarcSelectorToSendingDomainsTable extends Migration
{
  public function up()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
      $table->string('dkim', 50)->nullable()->after('tracking')->default('mail');
      $table->string('dmarc', 50)->nullable()->after('dkim')->default('dmarc');
    });
  }

  public function down()
  {
    Schema::table('sending_domains', function (Blueprint $table) {
       $table->dropColumn('dkim');
       $table->dropColumn('dmarc');
    });
  }
}
