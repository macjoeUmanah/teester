<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TriggerSchedule extends Model
{
  protected $fillable = ['contact_id', 'send_datetime', 'broadcast_id', 'sending_server_id', 'action', 'trigger_id'];
}
