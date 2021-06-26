<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySendingServerIdFieldToScheduleCampaingsTable extends Migration
{
    public function up()
    {
        $table = DB::getTablePrefix(). 'schedule_campaigns';
        DB::statement("ALTER TABLE $table CHANGE `sending_server_ids` `sending_server_ids` TEXT NULL DEFAULT NULL;");
        DB::statement("ALTER TABLE $table CHANGE `list_ids` `list_ids` TEXT NULL DEFAULT NULL;");
    }

    public function down()
    {
        Schema::table('schedule_campaigns', function (Blueprint $table) {
            //
        });
    }
}
