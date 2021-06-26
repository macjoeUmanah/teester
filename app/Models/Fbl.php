<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fbl extends Model
{
  protected $fillable = ['email', 'active', 'method', 'host', 'username', 'password', 'port', 'encryption', 'validate_cert', 'delete_after_processing', 'app_id', 'user_id'];

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
}
