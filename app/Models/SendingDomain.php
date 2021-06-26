<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendingDomain extends Model
{
  protected $fillable = ['domain', 'protocol', 'public_key', 'private_key', 'active', 'signing', 'app_id', 'user_id', 'pmta', 'spf_value',
  'tracking', 'dkim', 'dmarc', 'verified_dkim', 'verified_dmarc', 'verified_tracking'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  public static function getSendingDomains($return_type=null)
  {
    $domains = SendingDomain::whereActive('Yes')->whereAppId(\Auth::user()->app_id);
    return $return_type == 'json' ? $domains->pluck('domain', 'id')->toJson() : $domains->select('id', 'domain', 'tracking', 'protocol')->get();
  }
}
