<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTriggerIdToScheduleDripsTable extends Migration
{
    public function up()
    {
        Schema::table('schedule_drips', function (Blueprint $table) {
          $table->unsignedBigInteger('trigger_id')->nullable()->after('in_progress');
      });
    }

    public function down()
    {
        Schema::table('schedule_drips', function (Blueprint $table) {
          $table->dropColumn('trigger_id');
      });
    }
}
