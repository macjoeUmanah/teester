<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCampaignStatLog extends Model
{
  protected $fillable = ['schedule_campaign_stat_id', 'message_id', 'email', 'list', 'broadcast', 'sending_server', 'status'];
}
