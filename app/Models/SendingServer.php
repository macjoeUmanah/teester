<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendingServer extends Model
{
  protected $fillable = ['group_id', 'status', 'name', 'type', 'from_name', 'from_email', 'reply_email', 
    'sending_attributes', 'speed_attributes', 'bounce_id', 'app_id', 'user_id', 'pmta', 'tracking_domain'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  public function bounce()
  {
    return $this->belongsTo('App\Models\Bounce', 'bounce_id');
  }

  public static function groupSendingServers()
  {
    return Group::where('groups.type_id', config('mc.groups.sending_server'))
    ->where('groups.app_id', \Auth::user()->app_id)
    ->with('sendingServers')
    ->get();
  }

  public static function groupSendingServersClient($sending_server_ids)
  {
    return Group::join('sending_servers', 'sending_servers.group_id', '=', 'groups.id')
      ->select('groups.*')
      ->whereIn('sending_servers.id', $sending_server_ids)
      ->with('sendingServers')
      ->distinct('groups.id')
      ->get();
  }

  public static function getActiveSeningServers($sending_server_ids=[], $type=null)
  {
    $sendign_servers = SendingServer::whereStatus('Active')
      ->whereIn('id', $sending_server_ids)
      ->with('bounce')
      ->get();
    if($type == 'array') $sendign_servers = $sendign_servers->toArray();
    return $sendign_servers;
  }

  public static function getInActiveSeningServers($sending_server_ids=[], $type=null)
  {
    $sendign_servers = SendingServer::where('status', '<>', 'Active')
      ->whereIn('id', $sending_server_ids)
      ->with('bounce')
      ->get();
    if($type == 'array') $sendign_servers = $sendign_servers->toArray();
    return $sendign_servers;
  }
}
