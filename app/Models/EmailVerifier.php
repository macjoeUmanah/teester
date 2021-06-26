<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerifier extends Model
{
	protected $fillable = ['name', 'active', 'attributes', 'total_verified', 'type', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
