<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
  use Notifiable;
  protected $fillable = ['list_id', 'email', 'confirmed', 'verified', 'active', 'unsubscribed', 'format', 'source', 'app_id', 'user_id'];

  public function customFields()
  {
    return $this->belongsToMany('App\Models\CustomField', 'custom_field_contact', 'contact_id', 'custom_field_id')->withPivot('data');
  }

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
