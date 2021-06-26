<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDrip extends Model
{
  protected $fillable = ['name', 'drip_group_id', 'list_ids', 'sending_server_id', 'send_to_existing', 'trigger_id', 'in_progress', 'app_id', 'user_id'];

  public function group()
  {
    return $this->belongsTo('App\Models\Group', 'drip_group_id');
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
