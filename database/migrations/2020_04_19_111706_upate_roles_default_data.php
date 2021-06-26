<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpateRolesDefaultData extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'roles';
    DB::statement("UPDATE $table SET app_id=1, user_id=1 WHERE app_id is NULL;");
  }

  public function down()
  {
    Schema::table('roles', function (Blueprint $table) {
    });
  }
}
