<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCampaignStat extends Model
{
  protected $fillable = ['schedule_campaign_id', 'schedule_campaign_name', 'schedule_by', 'total', 'scheduled', 'sent', 'sending_speed', 'threads', 'sending_speed', 'scheduled_detail', 'start_datetime', 'app_id', 'user_id'];


  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }


  /**
   * Return query that helps to find opens for a scheduled
   * @param int schedule_campaign_stat_id
   * @param string all / unique
  */
  public static function statLogOpens($scheduel_campaign_stat_id, $filter='all')
  {
    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->join('schedule_campaign_stat_log_opens', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_opens.schedule_campaign_stat_log_id')
      ->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('schedule_campaign_stat_log_opens.schedule_campaign_stat_log_id')
        ->groupBy('schedule_campaign_stat_log_opens.schedule_campaign_stat_log_id');
    } else {
      $query = $query->select('schedule_campaign_stats.id as id', 'schedule_campaign_stats.schedule_campaign_name as name', 'schedule_campaign_stat_logs.id as stat_log_id', 'schedule_campaign_stat_logs.message_id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list', 'schedule_campaign_stat_logs.broadcast', 'schedule_campaign_stat_logs.sending_server', 'schedule_campaign_stat_logs.status', 'schedule_campaign_stat_log_opens.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find clicks for a scheduled
   * @param int schedule_campaign_stat_id
   * @param string all / unique
  */
  public static function statLogClicks($scheduel_campaign_stat_id, $filter='all')
  {
    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->join('schedule_campaign_stat_log_clicks', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_clicks.schedule_campaign_stat_log_id')
      ->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('schedule_campaign_stat_log_clicks.schedule_campaign_stat_log_id')
        ->groupBy('schedule_campaign_stat_log_clicks.schedule_campaign_stat_log_id');
    } else {
      $query = $query->select('schedule_campaign_stats.id as id', 'schedule_campaign_stats.schedule_campaign_name as name', 'schedule_campaign_stat_logs.id as stat_log_id', 'schedule_campaign_stat_logs.message_id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list', 'schedule_campaign_stat_logs.broadcast', 'schedule_campaign_stat_logs.sending_server', 'schedule_campaign_stat_logs.status', 'schedule_campaign_stat_log_clicks.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find bounces for a scheduled
   * @param int schedule_campaign_stat_id
  */
  public static function statLogBounces($scheduel_campaign_stat_id)
  {
    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->join('schedule_campaign_stat_log_bounces', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_bounces.schedule_campaign_stat_log_id')
      ->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id)
      ->where('schedule_campaign_stat_log_bounces.section', 'Campaign')
      ->select('schedule_campaign_stats.id as id', 'schedule_campaign_stats.schedule_campaign_name as name', 'schedule_campaign_stat_logs.id as stat_log_id', 'schedule_campaign_stat_logs.message_id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list', 'schedule_campaign_stat_logs.broadcast', 'schedule_campaign_stat_logs.sending_server', 'schedule_campaign_stat_logs.status', 'schedule_campaign_stat_log_bounces.*');
    return $query;
  }

  /**
   * Return query that helps to find spam for a scheduled
   * @param int schedule_campaign_stat_id
  */
  public static function statLogSpam($scheduel_campaign_stat_id)
  {
    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->join('schedule_campaign_stat_log_spams', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_spams.schedule_campaign_stat_log_id')
      ->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id)
      ->select('schedule_campaign_stats.id as id', 'schedule_campaign_stats.schedule_campaign_name as name', 'schedule_campaign_stat_logs.id as stat_log_id', 'schedule_campaign_stat_logs.message_id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list', 'schedule_campaign_stat_logs.broadcast', 'schedule_campaign_stat_logs.sending_server', 'schedule_campaign_stat_logs.status', 'schedule_campaign_stat_log_spams.*');;
    return $query;
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int schedule_campaign_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function statLogData($scheduel_campaign_stat_id, $value='list')
  {
    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id)
      ->select("schedule_campaign_stat_logs.{$value}")
      ->groupBy("schedule_campaign_stat_logs.{$value}")
      ->select("schedule_campaign_stat_logs.{$value}", \DB::raw('count(*) as total'));
    return $query;
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int schedule_campaign_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function getUniqueCountries($scheduel_campaign_stat_id=null, $table='opens')
  {
    $table = $table == 'opens' ? 'schedule_campaign_stat_log_opens' : 'schedule_campaign_stat_log_clicks';

    $query = ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->join($table, 'schedule_campaign_stat_logs.id', '=', "$table.schedule_campaign_stat_log_id");
      
    if(!empty($scheduel_campaign_stat_id)) {
      $query = $query->where('schedule_campaign_stats.id', $scheduel_campaign_stat_id);
    }

    $query = $query->select(\DB::raw('count(country_code) as cnt, country_code'))
      ->groupBy("$table.country_code");

    return $query;
  }

  // Get all scheduled campaing
  public static function getScheduledCampaigns()
  {
    return ScheduleCampaignStat::where('schedule_campaign_stats.app_id', \Auth::user()->app_id)->orderBy('id', 'desc')->get();
  }

  // Get all scheduled campaing links
  public static function getScheduledCampaignLinks($ids)
  {
    $broadcast_ids = ScheduleCampaignStat::whereIn('schedule_campaign_stats.id', explode(',', $ids))
      ->join('schedule_campaigns', 'schedule_campaign_stats.schedule_campaign_id', '=', 'schedule_campaigns.id')
      ->where('schedule_campaign_stats.app_id', \Auth::user()->app_id)
      ->pluck('broadcast_id');

    $links = \Helper::getBroadcastLinks($broadcast_ids);
    return $links;
  }

}
