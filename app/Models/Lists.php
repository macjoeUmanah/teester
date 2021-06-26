<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lists extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'group_id', 'sending_server_id', 'double_optin', 'welcome_email', 'unsub_email', 'notification', 'notification_attributes','attributes', 'app_id', 'user_id'];

  public function group()
  {
    return $this->belongsTo('App\Models\Group', 'group_id');
  }

  public function contacts()
  {
    return $this->hasMany('App\Models\Contact', 'list_id');
  }

  public function sendingServer()
  {
    return $this->belongsTo('App\Models\SendingServer', 'sending_server_id');
  }

  public function customFields()
  {
      return $this->belongsToMany('App\Models\CustomField', 'custom_field_list', 'list_id', 'custom_field_id')->select('custom_field_id', 'custom_fields.name', 'custom_fields.type', 'custom_fields.required', 'custom_fields.values');
  }

  public function getCustomFieldId()
  {
    return $this->customFields->pluck('custom_field_id');
  }

  public function getCustomFieldNameType()
  {
    return $this->customFields->pluck('name', 'type');
  }

  /**
   * Retrun list groups
  */
  public static function groupLists()
  {
    return Group::where('groups.type_id', config('mc.groups.lists'))
      ->where('groups.app_id', \Auth::user()->app_id)
      ->with('lists')
      ->get();
  }

  /**
   * Retrun list groups
  */
  public static function groupListsClient($list_ids)
  {
    return Group::join('lists', 'lists.group_id', '=', 'groups.id')
      ->select('groups.*')
      ->whereIn('lists.id', $list_ids)
      ->with('lists')
      ->distinct('groups.id')
      ->get();
  }

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }
}
