<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDripStat extends Model
{
  protected $fillable = ['schedule_drip_id', 'schedule_by', 'schedule_drip_name', 'drip_group_id', 'drip_group_name', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int schedule_drip_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function statLogData($scheduel_drip_stat_id, $value='list')
  {
    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->where('schedule_drip_stats.id', $scheduel_drip_stat_id)
      ->where('schedule_drip_stats.app_id', \Auth::user()->app_id)
      ->select("schedule_drip_stat_logs.{$value}")
      ->groupBy("schedule_drip_stat_logs.{$value}");
    return $query;
  }

  /**
   * Return query that helps to find opens for a scheduled
   * @param int scheduel_drip_stat_id
   * @param string all / unique
  */
  public static function statLogOpens($scheduel_drip_stat_id, $filter='all')
  {
    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->join('schedule_drip_stat_log_opens', 'schedule_drip_stat_logs.id', '=', 'schedule_drip_stat_log_opens.schedule_drip_stat_log_id')
      ->where('schedule_drip_stats.id', $scheduel_drip_stat_id)
      ->where('schedule_drip_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('schedule_drip_stat_log_opens.schedule_drip_stat_log_id')
        ->groupBy('schedule_drip_stat_log_opens.schedule_drip_stat_log_id');
    } else {
      $query = $query->select('schedule_drip_stats.id as id', 'schedule_drip_stat_logs.drip_name as drip_name', 'schedule_drip_stat_logs.id as stat_log_id', 'schedule_drip_stat_logs.message_id', 'schedule_drip_stat_logs.email', 'schedule_drip_stat_logs.list', 'schedule_drip_stat_logs.broadcast', 'schedule_drip_stat_logs.sending_server', 'schedule_drip_stat_logs.status', 'schedule_drip_stat_log_opens.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find clicks for a scheduled
   * @param int schedule_drip_stat_id
   * @param string all / unique
  */
  public static function statLogClicks($scheduel_drip_stat_id, $filter='all')
  {
    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->join('schedule_drip_stat_log_clicks', 'schedule_drip_stat_logs.id', '=', 'schedule_drip_stat_log_clicks.schedule_drip_stat_log_id')
      ->where('schedule_drip_stats.id', $scheduel_drip_stat_id)
      ->where('schedule_drip_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('schedule_drip_stat_log_clicks.schedule_drip_stat_log_id')
        ->groupBy('schedule_drip_stat_log_clicks.schedule_drip_stat_log_id');
    } else {
      $query = $query->select('schedule_drip_stats.id as id', 'schedule_drip_stat_logs.drip_name as drip_name', 'schedule_drip_stat_logs.id as stat_log_id', 'schedule_drip_stat_logs.message_id', 'schedule_drip_stat_logs.email', 'schedule_drip_stat_logs.list', 'schedule_drip_stat_logs.broadcast', 'schedule_drip_stat_logs.sending_server', 'schedule_drip_stat_logs.status', 'schedule_drip_stat_log_clicks.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find bounces for a scheduled
   * @param int schedule_drip_stat_id
  */
  public static function statLogBounces($scheduel_campaign_stat_id)
  {
    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->join('schedule_campaign_stat_log_bounces', 'schedule_drip_stat_logs.id', '=', 'schedule_campaign_stat_log_bounces.schedule_campaign_stat_log_id')
      ->where('schedule_drip_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_drip_stats.app_id', \Auth::user()->app_id)
      ->where('schedule_campaign_stat_log_bounces.section', 'Drip')
      ->select('schedule_drip_stats.id as id', 'schedule_drip_stat_logs.drip_name as drip_name', 'schedule_drip_stat_logs.id as stat_log_id', 'schedule_drip_stat_logs.message_id', 'schedule_drip_stat_logs.email', 'schedule_drip_stat_logs.list', 'schedule_drip_stat_logs.broadcast', 'schedule_drip_stat_logs.sending_server', 'schedule_drip_stat_logs.status', 'schedule_campaign_stat_log_bounces.*');
    return $query;
  }

  /**
   * Return query that helps to find spam for a scheduled
   * @param int schedule_drip_stat_id
  */
  public static function statLogSpam($scheduel_campaign_stat_id)
  {
    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->join('schedule_campaign_stat_log_spams', 'schedule_drip_stat_logs.id', '=', 'schedule_campaign_stat_log_spams.schedule_campaign_stat_log_id')
      ->where('schedule_drip_stats.id', $scheduel_campaign_stat_id)
      ->where('schedule_drip_stats.app_id', \Auth::user()->app_id)
      ->where('schedule_campaign_stat_log_spams.section', 'Drip')
      ->select('schedule_drip_stats.id as id', 'schedule_drip_stat_logs.drip_name as drip_name', 'schedule_drip_stat_logs.id as stat_log_id', 'schedule_drip_stat_logs.message_id', 'schedule_drip_stat_logs.email', 'schedule_drip_stat_logs.list', 'schedule_drip_stat_logs.broadcast', 'schedule_drip_stat_logs.sending_server', 'schedule_drip_stat_logs.status', 'schedule_campaign_stat_log_spams.*');;
    return $query;
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int schedule_drip_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function getUniqueCountries($scheduel_drip_stat_id=null, $table='opens')
  {
    $table = $table == 'opens' ? 'schedule_drip_stat_log_opens' : 'schedule_drip_stat_log_clicks';

    $query = ScheduleDripStat::join('schedule_drip_stat_logs', 'schedule_drip_stats.id', '=', 'schedule_drip_stat_logs.schedule_drip_stat_id')
      ->join($table, 'schedule_drip_stat_logs.id', '=', "$table.schedule_drip_stat_log_id");
      
    if(!empty($scheduel_drip_stat_id)) {
      $query = $query->where('schedule_drip_stats.id', $scheduel_drip_stat_id);
    }

    $query = $query->select(\DB::raw('count(country_code) as cnt, country_code'))
      ->groupBy("$table.country_code");

    return $query;
  }
}
