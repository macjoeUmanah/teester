<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
  protected $fillable = ['name', 'tag', 'type', 'values', 'required', 'app_id', 'user_id'];

  public function lists()
  {
      return $this->belongsToMany('App\Models\Lists', 'custom_field_list', 'custom_field_id', 'list_id')->select('list_id');
  }

  public function getListId()
  {
    return $this->lists->pluck('list_id');
  }

  /**
   * Retrun custom fields either with json or array
  */
  public static function customFields($return_type=null)
  {
    $custom_fields = CustomField::whereAppId(\Auth::user()->app_id)->pluck('name', 'id');
    if($return_type == 'json') { 
      $custom_fields->toJson();
    }
    return $custom_fields;
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
