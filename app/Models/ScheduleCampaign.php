<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCampaign extends Model
{
  protected $fillable = ['name', 'broadcast_id', 'list_ids', 'sending_server_ids', 'sent', 'send_datetime', 'threads', 'total_threads', 'total', 'sending_speed', 'app_id', 'user_id', 'scheduled', 'thread_no'];

  public function broadcast()
  {
    return $this->belongsTo('App\Models\Broadcast', 'broadcast_id');
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
