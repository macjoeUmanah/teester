<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
  protected $fillable = ['name', 'description', 'attributes', 'user_id', 'app_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
