<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broadcast extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'group_id', 'email_subject', 'content_html', 'content_text', 'app_id', 'user_id'];

  public function group()
  {
    return $this->belongsTo('App\Models\Group', 'group_id');
  }

  /**
   * Retrun broadcast groups
  */
  public static function groupBroadcasts()
  {
    return Group::where('groups.type_id', config('mc.groups.broadcasts'))
    ->where('groups.app_id', \Auth::user()->app_id)
    ->with('broadcasts')
    ->get();
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
