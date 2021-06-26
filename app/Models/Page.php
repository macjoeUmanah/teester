<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  protected $fillable = ['name', 'email_subject', 'slug', 'type', 'content_html', 'app_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  /**
   * Retrun custom fields either with json or array
  */
  public static function emails($return_type=null)
  {
    $custom_fields = Page::whereAppId(\Auth::user()->app_id)->whereType('Email')->pluck('name', 'id');
    if($return_type == 'json') { 
      $custom_fields->toJson();
    }
    return $custom_fields;
  }
}
