<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trigger extends Model
{
  use SoftDeletes;
  protected $fillable = ['name', 'active', 'based_on', 'action', 'sending_server_ids', 'attributes', 'in_progress', 'execution_datetime',
    'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  public function autoFollowupStat()
  {
    return $this->hasOne('App\Models\AutoFollowupStat', 'auto_followup_id');
  }

  public function scheduleDrip()
  {
    return $this->hasOne('App\Models\ScheduleDrip', 'trigger_id');
  }
}
