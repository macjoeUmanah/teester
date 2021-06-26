<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    $this->serverIP();
    // Get last 10 activites
    //$activities = \Spatie\Activitylog\Models\Activity::where('properties->app_id', Auth::user()->app_id)
    // For MariaDB
    $activities = \Spatie\Activitylog\Models\Activity::whereRaw("properties LIKE '%:".Auth::user()->app_id."%'")
      ->with('causer')
      ->orderBy('id', 'DESC')
      ->limit(10)
      ->get();

    $page = 'dashboard'; // choose sidebar menu option
    return view('dashboard.index')->with(compact('page', 'activities'));
  }

  /**
   * Retrurn JSON for sent campaigns
  */
  public function getSentData(Request $request, $type = null)
  {
    // default would be last 7 days
    $start_datetime = empty($request->start_datetime) ? Carbon::parse('now')->startOfDay()->subDays(6) : Carbon::parse($request->start_datetime);
    $end_datetime = empty($request->end_datetime) ? Carbon::parse('now')->endOfDay() : Carbon::parse($request->end_datetime);

    if($type == 'country') {
      $table_prefix = \DB::getTablePrefix();
      $offset =  \Helper::timeZonesOffset(Auth::user()->time_zone);
      $data = \App\Models\ScheduleCampaignStat::getUniqueCountries()
        ->where('schedule_campaign_stats.app_id' , Auth::user()->app_id)
        ->whereRaw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_log_opens.created_at, '+00:00', '{$offset}') BETWEEN '{$start_datetime}' AND '{$end_datetime}'")
        ->get()
        ->pluck('cnt', 'country_code')
        ->toArray();
    } elseif($type == 'domain') {
      $top_10_domains = $this->getTopDomains($start_datetime, $end_datetime)->limit(10)->get();
      $data_domain_names = $data_domain_counts = [];
      foreach($top_10_domains as $domain) {
        array_push($data_domain_names, $domain->name);
        array_push($data_domain_counts, $domain->count);
      }
      $dataset = [
        'data' => $data_domain_counts,
        'backgroundColor' => ['#8E44AD', '#E74C3C', '#909497', '#641E16', '#F9E79F', '#1B2631', '#A9DFBF', '#3C8DBC', '#F39B1F', '#AED6F1'],
      ];
      $data = [
        'labels' => $data_domain_names,
        'datasets' => [$dataset],
      ];
    } else {
      $diff = $start_datetime->diffInDays($end_datetime);
      $data_sent = $this->getCampiagnsStats('schedule_campaign_stat_logs',$start_datetime, $end_datetime, $diff)->get()->toArray();
      $data_opens = $this->getCampiagnsStats('schedule_campaign_stat_log_opens',$start_datetime, $end_datetime, $diff)->get()->toArray();
      $data_clicks = $this->getCampiagnsStats('schedule_campaign_stat_log_clicks',$start_datetime, $end_datetime, $diff)->get()->toArray();
      $data_unsubscribed = $this->getCampiagnsStats('schedule_campaign_stat_log_clicks',$start_datetime, $end_datetime, $diff)->where('link', 'like', '%/unsub/%')->get()->toArray();
      $data_bounces = $this->getCampiagnsStats('schedule_campaign_stat_log_bounces',$start_datetime, $end_datetime, $diff)->get()->toArray();
      $data_spam = $this->getCampiagnsStats('schedule_campaign_stat_log_spams',$start_datetime, $end_datetime, $diff)->get()->toArray();
      

      $labels = [];
      if($diff < 1) {
        $labels = range(0, 23); // Hours
        $sents = $opens = $clicks = $unsubscribed = $bounces = $spams = array_fill(0, 23, 0);
        $key = 'hour';
      } elseif($diff <= 31) {
        for($i=($diff-1); $i>=0; $i--) {
          $day = date('Y-m-d',strtotime("-$i day"));
          $labels[$day] = 0;
        }
        $sents = $opens = $clicks = $unsubscribed = $bounces = $spams = $labels;
        $key = 'day';
      } else {
        $labels = range(1, 12); // Years
        $sents = $opens = $clicks = $unsubscribed = $bounces = $spams = array_fill(0, 12, 0);
        $key = 'month';
      }


      foreach($data_sent as $sent) {
        $sents[$sent[$key]] = $sent['count'];
      }
      foreach($data_opens as $open) {
        $opens[$open[$key]] = $open['count'];
      }
      foreach($data_clicks as $click) {
        $clicks[$click[$key]] = $click['count'];
      }
      foreach($data_unsubscribed as $unsub) {
        $unsubscribed[$unsub[$key]] = $unsub['count'];
      }
      foreach($data_bounces as $bounce) {
        $bounces[$bounce[$key]] = $bounce['count'];
      }
      foreach($data_spam as $spam) {
        $spams[$spam[$key]] = $spam['count'];
      }

      $data = [
        "labels"  => array_keys($labels),
        "datasets" => [
          [
            "label"             => __('app.sent'),
            "fill"              => false,
            "borderColor"       => '#00A65A',
            "backgroundColor"   => '#00A65A',
            "data"              => array_values($sents)
          ],
          [
            "label"             => __('app.opens'),
            "fill"              => false,
            "borderColor"       => '#3C8DBC',
            "backgroundColor"   => '#3C8DBC',
            "data"              => array_values($opens)
          ],
          [
            "label"             => __('app.clicks'),
            "fill"              => false,
            "borderColor"       => '#8B4513',
            "backgroundColor"   => '#8B4513',
            "data"              => array_values($clicks)
          ],
          [
            "label"             => __('app.unsubscribed'),
            "fill"              => false,
            "borderColor"       => '#FF851B',
            "backgroundColor"   => '#FF851B',
            "data"              => array_values($unsubscribed)
          ],
          [
            "label"             => __('app.bounces'),
            "fill"              => false,
            "borderColor"       => '#DD4B39',
            "backgroundColor"   => '#DD4B39',
            "data"              => array_values($bounces)
          ],
          [
            "label"             => __('app.spam'),
            "fill"              => false,
            "borderColor"       => '#FFC0CB',
            "backgroundColor"   => '#FFC0CB',
            "data"   => array_values($spams)
          ],
        ]
      ];
    }

    return json_encode($data);
  }

  /**
   * Retrurn query for domains decending order
  */
  public function getTopDomains($start_datetime, $end_datetime)
  {
    $table_prefix = \DB::getTablePrefix();
    $offset =  \Helper::timeZonesOffset(Auth::user()->time_zone);
    $query = \App\Models\ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->where('schedule_campaign_stats.app_id' , Auth::user()->app_id)
      ->whereRaw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_logs.created_at, '+00:00', '{$offset}') BETWEEN '{$start_datetime}' AND '{$end_datetime}'")
      ->select(
        \DB::raw("substring_index({$table_prefix}schedule_campaign_stat_logs.email, '@', -1) as name"), 
        \DB::raw("count(substring_index({$table_prefix}schedule_campaign_stat_logs.email, '@', -1)) as count")
      )
      ->groupBy('name')
      ->orderBy('count', 'DESC');

    return $query;
  }

  /**
   * Retrurn query(opens/clicks/bounces/spam) of sent campaigns
  */
  public function getCampiagnsStats($table, $start_datetime, $end_datetime, $diff)
  {
    $table_prefix = \DB::getTablePrefix();
    $offset =  \Helper::timeZonesOffset(Auth::user()->time_zone);
    $query = \App\Models\ScheduleCampaignStat::join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id')
      ->where('schedule_campaign_stats.app_id' , Auth::user()->app_id)
      ->whereRaw("CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}') BETWEEN '{$start_datetime}' AND '{$end_datetime}'");

      if($table != 'schedule_campaign_stat_logs') {
        $query = $query->join("{$table}", 'schedule_campaign_stat_logs.id', '=', "{$table}.schedule_campaign_stat_log_id");
      }

      // For 1 day
      if($diff < 1) {
        $query = $query->select(
          \DB::raw("HOUR(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}')) as hour"),
          \DB::raw("count({$table_prefix}{$table}.id) as count")
        )
        ->groupBy(\DB::raw("HOUR(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}'))"));
      } 
      // For less than one month
      elseif($diff <= 31) {
        $query = $query->select(
          \DB::raw("DATE(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}')) as day"),
          \DB::raw("count({$table_prefix}{$table}.id) as count")
        )
        ->groupBy(\DB::raw("DATE(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}'))"));
      } 
      // For year
      else {
        $query = $query->select(
          \DB::raw("MONTH(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}')) as month"),
          \DB::raw("count({$table_prefix}{$table}.id) as count")
        )
        ->groupBy(\DB::raw("YEAR(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}')), MONTH(CONVERT_TZ({$table_prefix}{$table}.created_at, '+00:00', '{$offset}'))"));
      }

    return $query;
  }

  /**
   * WARNING! Any changes in this function can casue system crash
  */
  private function serverIP()
  {
    \DB::table('settings')->whereId(config('mc.app_id'))->update([
      'server_ip' => $_SERVER['SERVER_ADDR']
    ]);
  }
}
