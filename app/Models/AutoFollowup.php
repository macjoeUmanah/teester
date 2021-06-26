<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowup extends Model
{
  protected $fillable = ['active', 'name', 'segment_id', 'broadcast_id', 'sending_server_id', 'send', 'after_minutes', 'send_attributes', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
