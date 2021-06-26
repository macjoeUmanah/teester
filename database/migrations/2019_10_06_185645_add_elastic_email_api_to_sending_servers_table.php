<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElasticEmailApiToSendingServersTable extends Migration
{
  public function up()
  {
    $table = DB::getTablePrefix(). 'sending_servers';
    DB::statement("ALTER TABLE $table CHANGE `type` `type` ENUM('php_mail','smtp','amazon_ses_api','mailgun_api','sparkpost_api','sendgrid_api','mandrill_api','elastic_email_api') NOT NULL DEFAULT 'smtp';");
  }

  public function down()
  {
    $table = DB::getTablePrefix(). 'sending_servers';
    DB::statement("ALTER TABLE $table CHANGE `type` `type` ENUM('php_mail','smtp','amazon_ses_api','mailgun_api','sparkpost_api','sendgrid_api','mandrill_api') NOT NULL DEFAULT 'smtp';");
  }
}
