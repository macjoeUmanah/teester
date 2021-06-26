<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drip extends Model
{
  protected $fillable = ['active', 'name', 'group_id', 'broadcast_id', 'send', 'after_minutes', 'send_attributes', 'app_id', 'user_id'];

  public function group()
  {
    return $this->belongsTo('App\Models\Group', 'group_id');
  }

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
