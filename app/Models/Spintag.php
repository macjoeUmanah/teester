<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spintag extends Model
{
  protected $fillable = ['name', 'tag', 'values', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  public static function customFields($return_type=null)
  {
    $custom_fields = Spintag::pluck('name', 'id');
    if($return_type == 'json') { 
      $custom_fields->toJson();
    }
    return $custom_fields;
  }
}
