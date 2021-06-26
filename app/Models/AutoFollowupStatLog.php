<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStatLog extends Model
{
  protected $fillable = ['auto_followup_stat_id', 'message_id', 'email', 'list', 'broadcast', 'sending_server', 'status'];
}
