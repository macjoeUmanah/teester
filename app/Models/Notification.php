<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  protected $fillable = ['name', 'type', 'attributes', 'is_read', 'app_id', 'user_id'];

  public function scopeApp($query, $app_id)
  {
    return $query->whereAppId($app_id);
  }

  public static function notifications()
  {
    $notifications = [];
    if(!empty(\Auth::user()->app_id)) {
      $notifications = \App\Models\Notification::whereIsRead(0)
        ->app(\Auth::user()->app_id)
        ->orderBy('id', 'DESC')
        ->get();
    }
    return $notifications;
  }
}
