<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCampaignStatLogBounce extends Model
{
  protected $fillable = ['schedule_campaign_stat_log_id', 'section', 'email', 'status', 'type', 'code', 'detail', 'created_at'];

  public $timestamps = false;
}
