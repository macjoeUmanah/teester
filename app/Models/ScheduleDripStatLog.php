<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDripStatLog extends Model
{
  protected $fillable = ['schedule_drip_stat_id', 'drip_id', 'drip_name', 'message_id', 'email', 'list', 'broadcast', 'sending_server', 'status'];
}
