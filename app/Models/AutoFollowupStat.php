<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoFollowupStat extends Model
{
  protected $fillable = ['auto_followup_id', 'auto_followup_name', 'schedule_by', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int auto_followup_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function statLogData($auto_followup_stat_id, $value='list')
  {
    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->where('auto_followup_stats.id', $auto_followup_stat_id)
      ->where('auto_followup_stats.app_id', \Auth::user()->app_id)
      ->select("auto_followup_stat_logs.{$value}")
      ->groupBy("auto_followup_stat_logs.{$value}");
    return $query;
  }

  /**
   * Return query that helps to find opens for a scheduled
   * @param int auto_followup_stat_id
   * @param string all / unique
  */
  public static function statLogOpens($auto_followup_stat_id, $filter='all')
  {
    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->join('auto_followup_stat_log_opens', 'auto_followup_stat_logs.id', '=', 'auto_followup_stat_log_opens.auto_followup_stat_log_id')
      ->where('auto_followup_stats.id', $auto_followup_stat_id)
      ->where('auto_followup_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('auto_followup_stat_log_opens.auto_followup_stat_log_id')
        ->groupBy('auto_followup_stat_log_opens.auto_followup_stat_log_id');
    } else {
      $query = $query->select('auto_followup_stats.id as id', 'auto_followup_stats.auto_followup_name as name', 'auto_followup_stat_logs.id as stat_log_id', 'auto_followup_stat_logs.message_id', 'auto_followup_stat_logs.email', 'auto_followup_stat_logs.list', 'auto_followup_stat_logs.broadcast', 'auto_followup_stat_logs.sending_server', 'auto_followup_stat_logs.status', 'auto_followup_stat_log_opens.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find clicks for a scheduled
   * @param int auto_followup_stat_id
   * @param string all / unique
  */
  public static function statLogClicks($auto_followup_stat_id, $filter='all')
  {
    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->join('auto_followup_stat_log_clicks', 'auto_followup_stat_logs.id', '=', 'auto_followup_stat_log_clicks.auto_followup_stat_log_id')
      ->where('auto_followup_stats.id', $auto_followup_stat_id)
      ->where('auto_followup_stats.app_id', \Auth::user()->app_id);

    if($filter == 'unique') {
      $query = $query->select('auto_followup_stat_log_clicks.auto_followup_stat_log_id')
        ->groupBy('auto_followup_stat_log_clicks.auto_followup_stat_log_id');
    } else {
      $query = $query->select('auto_followup_stats.id as id', 'auto_followup_stats.auto_followup_name as name', 'auto_followup_stat_logs.id as stat_log_id', 'auto_followup_stat_logs.message_id', 'auto_followup_stat_logs.email', 'auto_followup_stat_logs.list', 'auto_followup_stat_logs.broadcast', 'auto_followup_stat_logs.sending_server', 'auto_followup_stat_logs.status', 'auto_followup_stat_log_clicks.*');
    }
    return $query;
  }

  /**
   * Return query that helps to find bounces for a scheduled
   * @param int auto_followup_stat_id
  */
  public static function statLogBounces($scheduel_campaign_stat_id)
  {
    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->join('schedule_campaign_stat_log_bounces', 'auto_followup_stat_logs.id', '=', 'schedule_campaign_stat_log_bounces.schedule_campaign_stat_log_id')
      ->where('auto_followup_stats.id', $scheduel_campaign_stat_id)
      ->where('auto_followup_stats.app_id', \Auth::user()->app_id)
      ->where('schedule_campaign_stat_log_bounces.section', 'AutoFollowup')
      ->select('auto_followup_stats.id as id', 'auto_followup_stats.auto_followup_name as name', 'auto_followup_stat_logs.id as stat_log_id', 'auto_followup_stat_logs.message_id', 'auto_followup_stat_logs.email', 'auto_followup_stat_logs.list', 'auto_followup_stat_logs.broadcast', 'auto_followup_stat_logs.sending_server', 'auto_followup_stat_logs.status', 'schedule_campaign_stat_log_bounces.*');
    return $query;
  }

  /**
   * Return query that helps to find spam for a scheduled
   * @param int auto_followup_stat_id
  */
  public static function statLogSpam($scheduel_campaign_stat_id)
  {
    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->join('schedule_campaign_stat_log_spams', 'auto_followup_stat_logs.id', '=', 'schedule_campaign_stat_log_spams.schedule_campaign_stat_log_id')
      ->where('auto_followup_stats.id', $scheduel_campaign_stat_id)
      ->where('auto_followup_stats.app_id', \Auth::user()->app_id)
      ->where('schedule_campaign_stat_log_spams.section', 'AutoFollowup')
      ->select('auto_followup_stats.id as id', 'auto_followup_stats.auto_followup_name as name', 'auto_followup_stat_logs.id as stat_log_id', 'auto_followup_stat_logs.message_id', 'auto_followup_stat_logs.email', 'auto_followup_stat_logs.list', 'auto_followup_stat_logs.broadcast', 'auto_followup_stat_logs.sending_server', 'auto_followup_stat_logs.status', 'schedule_campaign_stat_log_spams.*');;
    return $query;
  }

  /**
   * Return query that helps to find unique data like lists, boradcasts, and sending_serers for schedule
   * @param int auto_followup_stat_id
   * @param strin list, broadcast, sending_server
  */
  public static function getUniqueCountries($auto_followup_stat_id=null, $table='opens')
  {
    $table = $table == 'opens' ? 'auto_followup_stat_log_opens' : 'auto_followup_stat_log_clicks';

    $query = AutoFollowupStat::join('auto_followup_stat_logs', 'auto_followup_stats.id', '=', 'auto_followup_stat_logs.auto_followup_stat_id')
      ->join($table, 'auto_followup_stat_logs.id', '=', "$table.auto_followup_stat_log_id");
      
    if(!empty($auto_followup_stat_id)) {
      $query = $query->where('auto_followup_stats.id', $auto_followup_stat_id);
    }

    $query = $query->select(\DB::raw('count(country_code) as cnt, country_code'))
      ->groupBy("$table.country_code");

    return $query;
  }
}
