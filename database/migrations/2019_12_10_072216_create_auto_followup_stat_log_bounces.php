<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoFollowupStatLogBounces extends Migration
{
  public function up()
  {
    Schema::create('auto_followup_stat_log_bounces', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('auto_followup_stat_log_id')->unique('afslb_afslid_unique');
      $table->string('email')->nullable();
      $table->enum('type', ['Soft', 'Hard'])->default('Soft');
      $table->string('code')->nullable();
      $table->json('detail')->nullable();
      $table->timestamp('created_at')->useCurrent();

      $table->foreign('auto_followup_stat_log_id', 'afslb_id_afsl_id')->references('id')->on('auto_followup_stat_logs')->onDelete('cascade');

      $table->engine = 'InnoDB';
    });
  }

  public function down()
  {
    Schema::dropIfExists('auto_followup_stat_log_bounces');
  }
}
