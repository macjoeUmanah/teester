<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'type_id', 'app_id', 'user_id'];

  public function lists()
  {
    return $this->hasMany('App\Models\Lists')->withCount('contacts');
  }

  public function broadcasts()
  {
    return $this->hasMany('App\Models\Broadcast');
  }

  public function sendingServers()
  {
    return $this->hasMany('App\Models\SendingServer')->whereStatus('Active');
  }

  public function scopeApp($query, $app_id)
  {
    return $query->whereAppId($app_id);
  }

  public static function groups($type_id, $return_type=null)
  {
    $groups = Group::whereTypeId($type_id)->whereAppId(\Auth::user()->app_id)->pluck('name', 'id');
    if($return_type == 'json') { 
      $groups->toJson();
    }
    return $groups;
  }
}
