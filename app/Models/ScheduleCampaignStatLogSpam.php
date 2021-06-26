<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCampaignStatLogSpam extends Model
{
  protected $table = 'schedule_campaign_stat_log_spams';
  protected $fillable = ['schedule_campaign_stat_log_id', 'section', 'email', 'detail', 'created_at'];
  public $timestamps = false;
}
