<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bounce extends Model
{
  protected $fillable = ['email', 'active', 'method', 'host', 'username', 'password', 'port', 'encryption', 'validate_cert', 'delete_after_processing', 'app_id', 'user_id', 'pmta'];

  /**
   * Retrun query with active status
  */
  public function scopeActive($query)
  {
    return $query->where('active', 'Yes');
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  /**
   * Retrun bounces either with json or array
  */
  public static function getBounces($return_type=null)
  {
    $bounces = Bounce::where('active', 'Yes')->whereAppId(\Auth::user()->app_id);
    return $return_type == 'json' ? $bounces->pluck('email', 'id')->toJson() : $bounces->select('id', 'email')->get();
  }
}
