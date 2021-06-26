<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
  protected $fillable = ['name', 'content', 'app_id', 'user_id', 'type'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
