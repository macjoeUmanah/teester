<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webform extends Model
{
  protected $fillable = ['name', 'duplicates', 'list_id', 'custom_field_ids', 'app_id', 'user_id', 'attributes'];

  public function list()
  {
    return $this->belongsTo('App\Models\Lists', 'list_id');
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
