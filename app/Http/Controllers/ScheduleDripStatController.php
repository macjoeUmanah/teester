<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleDripStat;
use Helper;
use Auth;

class ScheduleDripStatController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('stats_drips'); // check user permission
    $page = 'stats_drip'; // choose sidebar menu option
    $title = __('app.stats').' - '.__('app.drips');
    $groups = \App\Models\Group::groups(config('mc.groups.drips'));
    return view('stats.drips.index')->with(compact('page', 'title', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getStatsDrips(Request $request) {
    $result = ScheduleDripStat::select('id', 'schedule_drip_name', 'drip_group_name', 'created_at')
      ->where('schedule_drip_stats.app_id', Auth::user()->app_id);

    $columns = ['schedule_drip_name', 'drip_group_name', 'id', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.drip', [$stat->id, 'summary', 'stats.drips.summary_popup']).'\')">'.$stat->schedule_drip_name.'</a>';
      $detail = '<a href="'.route('detail.stat.drip', ['id' => $stat->id]).'"><i class="fa fa-bar-chart"></i></a>';
      $data['data'][] = [
        $name,
        $stat->drip_group_name,
        \App\Models\ScheduleDripStatLog::whereScheduleDripStatId($stat->id)->get()->count(),
        Helper::datetimeDisplay($stat->created_at),
        $detail
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn all opens and unique opens with percentage
  */
  public function opensAllUniqueWithPecentage($stat_id, $stat_sent)
  {
    $opens_all = ScheduleDripStat::statLogOpens($stat_id)->get()->count();
    $opens_unique = ScheduleDripStat::statLogOpens($stat_id, 'unique')->get()->count();
    return $opens = "( <a title='".__('app.unique')."'>{$opens_unique}</a> / <a title='".__('app.all')."'>{$opens_all}</a> ) " . Helper::getPercnetage($opens_unique, $stat_sent);
  }

  /**
   * Retrurn all clicks and unique clicks with percentage
  */
  public function clicksAllUniqueWithPecentage($stat_id, $stat_sent)
  {
    $clicks_all = ScheduleDripStat::statLogClicks($stat_id)->get()->count();
    $clicks_unique = ScheduleDripStat::statLogClicks($stat_id, 'unique')->get()->count();
    return $clicks = "( <a title='".__('app.unique')."'>{$clicks_unique}</a> / <a title='".__('app.all')."'>{$clicks_all}</a> ) " . Helper::getPercnetage($clicks_unique, $stat_sent);
  }

  /**
   * Retrurn detail view for a scheduled drip
  */
  public function getDetailStat($id, $type=null, $view='stats.drips.summary')
  {
    Helper::checkPermissions('stats_drips'); // check user permission
    $schedule_stat = ScheduleDripStat::whereId($id)->app()->first();
    if(empty($type)) {
      $page = 'stats_drip'; // choose sidebar menu option
      $title = __('app.stats').' - '.__('app.triggers').' - '.$schedule_stat->schedule_drip_name;
      return view('stats.drips.detail')->with(compact('page', 'title', 'schedule_stat'));
    } else {
      switch($type) {
        case 'opens':
          return view('stats.drips.opens')->with('stat_id', $id);
        break;
        case 'clicks':
          return view('stats.drips.clicks')->with('stat_id', $id);
        break;
        case 'unsubscribed':
          return view('stats.drips.unsubscribed')->with('stat_id', $id);
        break;
        case 'bounces':
          return view('stats.drips.bounces')->with('stat_id', $id);
        break;
        case 'spam':
          return view('stats.drips.spam')->with('stat_id', $id);
        break;
        case 'logs':
          return view('stats.drips.logs')->with('stat_id', $id);
        break;
        default:
          $data = $this->getSummary($schedule_stat, $view);
      }
      return $data;
    }
  }

  /**
   * Retrurn summary for a scheduled drip
  */
  public function getSummary($schedule_stat, $view='stats.drips.summary')
  {
    $sent = \App\Models\ScheduleDripStatLog::whereScheduleDripStatId($schedule_stat->id)->get()->count();
    $opens = $this->opensAllUniqueWithPecentage($schedule_stat->id, $sent);
    $clicks = $this->clicksAllUniqueWithPecentage($schedule_stat->id, $sent);
    $unsubscribed = ScheduleDripStat::statLogClicks($schedule_stat->id)->where('link', 'like', '%/unsub/%')->get()->count();
    $bounces = ScheduleDripStat::statLogBounces($schedule_stat->id)->get()->count();
    $spam = ScheduleDripStat::statLogSpam($schedule_stat->id)->get()->count();
    return view($view)->with(compact('schedule_stat', 'sent', 'opens', 'clicks', 'unsubscribed', 'bounces', 'spam'));
  }

  /**
   * Retrurn opens for a scheduled drip
  */
  public function getOpens(Request $request)
  {
    $result = ScheduleDripStat::statLogOpens($request->stat_id);

    $columns = ['drip_name', 'email', 'list', 'sending_server', 'message_id', 'ip', 'country', 'zipcode', 'city', 'schedule_drip_stat_log_opens.created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $country = empty($stat->country) ? '---' : $stat->country;
      $city = empty($stat->city) ? '---' : $stat->city;
      $zipcode = empty($stat->zipcode) ? '---' : $stat->zipcode;
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        $stat->ip,
        $country,
        $city,
        $zipcode,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }


  /**
   * Retrurn clicks for a scheduled drip
  */
  public function getClicks(Request $request)
  {
    $result = ScheduleDripStat::statLogClicks($request->stat_id);

    $columns = ['drip_name', 'email', 'link', 'list', 'sending_server', 'message_id', 'ip', 'country', 'zipcode', 'city', 'schedule_drip_stat_log_clicks.created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $country = empty($stat->country) ? '---' : $stat->country;
      $city = empty($stat->city) ? '---' : $stat->city;
      $zipcode = empty($stat->zipcode) ? '---' : $stat->zipcode;
      $link = '<a href="javascript:;" onclick="swal(\''.$stat->link.'\')">'.substr($stat->link, 0, 20).'...</a>';
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $link,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        $stat->ip,
        $country,
        $city,
        $zipcode,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn unsubscribed for a scheduled drip
  */
  public function getUnsubscribed(Request $request)
  {
    $result = ScheduleDripStat::statLogClicks($request->stat_id)
      ->where('link', 'like', '%/unsub/%');

    $columns = ['drip_name', 'email', 'link', 'list', 'sending_server', 'message_id', 'ip', 'country', 'zipcode', 'city', 'schedule_drip_stat_log_clicks.created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $country = empty($stat->country) ? '---' : $stat->country;
      $city = empty($stat->city) ? '---' : $stat->city;
      $zipcode = empty($stat->zipcode) ? '---' : $stat->zipcode;
      $link = '<a href="javascript:;" onclick="swal(\''.$stat->link.'\')">'.substr($stat->link, 0, 20).'...</a>';
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $link,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        $stat->ip,
        $country,
        $city,
        $zipcode,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn bounces for a scheduled drip
  */
  public function getBounces(Request $request)
  {
    $result = ScheduleDripStat::statLogBounces($request->stat_id);

    $columns = ['drip_name', 'schedule_campaign_stat_log_bounces.email', 'list', 'sending_server', 'message_id', 'type', 'code', 'detail', 'schedule_campaign_stat_log_bounces.created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        $stat->type,
        $stat->code,
        json_decode($stat->detail)->short_detail,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn spam for a scheduled drip
  */
  public function getSpam(Request $request)
  {
    $result = ScheduleDripStat::statLogSpam($request->stat_id);

    $columns = ['drip_name', 'schedule_campaign_stat_log_spams.email', 'list', 'sending_server', 'message_id', 'detail', 'schedule_campaign_stat_log_spams.created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        json_decode($stat->detail)->full_detail,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn all info for a scheduled drip
  */
  public function getLogs(Request $request)
  {
    $result = \App\Models\ScheduleDripStatLog::whereScheduleDripStatId($request->stat_id);

    $columns = ['drip_name', 'email', 'list', 'sending_server', 'message_id', 'status', 'created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      $data['data'][] = [
        $stat->drip_name,
        $stat->email,
        $stat->list,
        $stat->sending_server,
        $stat->message_id,
        $stat->status,
        Helper::datetimeDisplay($stat->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrurn JSON for a sent drip 
  */
  public function getSentData($id, $type = null)
  {
    if($type == 'country') {
      $data = ScheduleDripStat::getUniqueCountries($id)->get()->pluck('cnt', 'country_code')->toArray();
    } else {
      $opens_unique = ScheduleDripStat::statLogOpens($id, 'unique')->get()->count();
      $clicks_unique = ScheduleDripStat::statLogClicks($id, 'unique')->get()->count();
      $unsubscribed = ScheduleDripStat::statLogClicks($id, 'unique')->where('link', 'like', '%/unsub/%')->get()->count();
      $bounces = ScheduleDripStat::statLogBounces($id)->get()->count();
      $spam = ScheduleDripStat::statLogSpam($id)->get()->count();
      $dataset = [
        'data' => [$opens_unique, $clicks_unique, $unsubscribed, $bounces, $spam],
        'backgroundColor' => ['#3C8DBC', '#8B4513', '#FF851B', '#DD4B39', '#FFC0CB'],
      ];
      $data = [
        'labels' => [
          "$opens_unique ".__('app.opens'),
          "$clicks_unique ".__('app.clicks'),
          "$unsubscribed ".__('app.unsubscribed'),
          "$bounces ".__('app.bounces'),
          "$spam ".__('app.spam')
        ],
        'datasets' => [$dataset],
      ];
    }
    return json_encode($data);
  }

  /**
   * Export drip stat detail
  */
  public function export($id)
  {
    $schedule_stat = ScheduleDripStat::whereId($id)->app()->first();

    $path_export_stat = str_replace('[user-id]', Auth::user()->app_id, config('mc.path_export_stat_drip'));
    Helper::dirCreateOrExist($path_export_stat); // create dir if not exist

    // Summary PDF File
    $file_summary = $path_export_stat.$id.'-summary.pdf';

    // Get Summary
    $html = $this->getSummary($schedule_stat);
    \PDF::loadHTML($html)->setPaper('a4')->setWarnings(false)->save($file_summary);

    // Opens CSV File
    $file_opens = $path_export_stat.$id.'-opens.csv';
    $this->exportOpens($id, $file_opens);

    // Clicks CSV File
    $file_clicks = $path_export_stat.$id.'-clicks.csv';
    $this->exportClicks($id, $file_clicks);

    // Unsubscribed CSV File
    $file_clicks = $path_export_stat.$id.'-unsubscribed.csv';
    $this->exportUnsubscribed($id, $file_clicks);

    // Bounces CSV File
    $file_bounces = $path_export_stat.$id.'-bounces.csv';
    $this->exportBounces($id, $file_bounces);

    // Spam CSV File
    $file_spam = $path_export_stat.$id.'-spam.csv';
    $this->exportSpam($id, $file_spam);

    // Logs CSV File
    $file_logs = $path_export_stat.$id.'-logs.csv';
    $this->exportLogs($id, $file_logs);


    // Make Zip
    $zip_file = $path_export_stat.$id.'.zip';
    $zipper = new \Chumper\Zipper\Zipper;
    $zipper->make($zip_file)->add($file_summary);
    $zipper->make($zip_file)->add($file_opens);
    $zipper->make($zip_file)->add($file_clicks);
    $zipper->make($zip_file)->add($file_bounces);
    $zipper->make($zip_file)->add($file_spam);
    $zipper->make($zip_file)->add($file_logs);
    $zipper->close();


    // Delete other files after created zip
    unlink($file_summary);
    unlink($file_opens);
    unlink($file_clicks);
    unlink($file_bounces);
    unlink($file_spam);
    unlink($file_logs);

  }

  /**
   * Download export drip stat detail
  */
  public function exportDownload($id)
  {
    try{
      $path_export_stat = str_replace('[user-id]', Auth::user()->app_id, config('mc.path_export_stat_drip'));
      $zip_file = $path_export_stat.$id.'.zip';
      return response()->download($zip_file)->deleteFileAfterSend(true);
    } catch(\Exception $e) {
      // if file not found
      return redirect(route('detail.stat.drip', ['id' => $id]));
    }
  }

  // Export drip opens
  public function exportOpens($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.ip'),
      __('app.country'),
      __('app.city'),
      __('app.zip_code'),
      __('app.datetime'),
    ];

    // Write file header

    $writer->insertOne($file_header);
    // Get Opens
    ScheduleDripStat::statLogOpens($id)
      ->chunk(1000, function ($opens)  use ($writer) {
        foreach($opens as $open) {
          $opens_data = [
            $open->drip_name,
            $open->email,
            $open->list,
            $open->sending_server,
            $open->message_id,
            $open->ip,
            $open->country,
            $open->city,
            $open->zipcode,
            Helper::datetimeDisplay($open->created_at),
          ];

          // Write open data
          $writer->insertOne($opens_data);
        }
    });
  }

  // Export drip clicks
  public function exportClicks($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.link'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.ip'),
      __('app.country'),
      __('app.city'),
      __('app.zip_code'),
      __('app.datetime'),
    ];

    // Write file header
    $writer->insertOne($file_header);

    // Get Clicks
    ScheduleDripStat::statLogClicks($id)
      ->chunk(1000, function ($clicks)  use ($writer) {
        foreach($clicks as $click) {
          $clicks_data = [
            $click->drip_name,
            $click->email,
            $click->link,
            $click->list,
            $click->sending_server,
            $click->message_id,
            $click->ip,
            $click->country,
            $click->city,
            $click->zipcode,
            Helper::datetimeDisplay($click->created_at),
          ];

          // Write click data
          $writer->insertOne($clicks_data);
        }
    });
  }

  // Export drip unsubscribed
  public function exportUnsubscribed($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.link'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.ip'),
      __('app.country'),
      __('app.city'),
      __('app.zip_code'),
      __('app.datetime'),
    ];

    // Write file header
    $writer->insertOne($file_header);

    // Get Clicks
    ScheduleDripStat::statLogClicks($id)
      ->where('link', 'like', '%/unsub/%')
      ->chunk(1000, function ($clicks)  use ($writer) {
        foreach($clicks as $click) {
          $clicks_data = [
            $click->drip_name,
            $click->email,
            $click->link,
            $click->list,
            $click->sending_server,
            $click->message_id,
            $click->ip,
            $click->country,
            $click->city,
            $click->zipcode,
            Helper::datetimeDisplay($click->created_at),
          ];

          // Write click data
          $writer->insertOne($clicks_data);
        }
    });
  }

  // Export drip bounces
  public function exportBounces($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.type'),
      __('app.code'),
      __('app.detail'),
      __('app.datetime'),
    ];

    // Write file header
    $writer->insertOne($file_header);

    // Get Bounces
    ScheduleDripStat::statLogBounces($id)
      ->chunk(1000, function ($bounces)  use ($writer) {
        foreach($bounces as $bounce) {
          $bounces_data = [
            $bounce->drip_name,
            $bounce->email,
            $bounce->list,
            $bounce->sending_server,
            $bounce->message_id,
            $bounce->type,
            $bounce->code,
            json_decode($bounce->detail)->short_detail,
            Helper::datetimeDisplay($bounce->created_at),
          ];

          // Write bounce data
          $writer->insertOne($bounces_data);
        }
    });
  }

  // Export drip spam
  public function exportSpam($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.detail'),
      __('app.datetime'),
    ];

    // Write file header
    $writer->insertOne($file_header);

    // Get Spam
    ScheduleDripStat::statLogSpam($id)
      ->chunk(1000, function ($spams)  use ($writer) {
        foreach($spams as $spam) {
          $spam_data = [
            $spam->drip_name,
            $spam->email,
            $spam->list,
            $spam->sending_server,
            $spam->message_id,
            json_decode($spam->detail)->full_detail,
            Helper::datetimeDisplay($spam->created_at),
          ];

          // Write bounce data
          $writer->insertOne($spam_data);
        }
    });
  }

  // Export drip logs
  public function exportLogs($id, $file)
  {
    // Create a .csv file to write data
    $writer = \League\Csv\Writer::createFromPath($file, 'w+');

    $file_header = [
      __('app.drip'),
      __('app.email'),
      __('app.list'),
      __('app.sending_server'),
      __('app.message_id'),
      __('app.latest_activity'),
      __('app.datetime'),
    ];

    // Write file header
    $writer->insertOne($file_header);

    // Get Logs
    \App\Models\ScheduleDripStatLog::whereScheduleDripStatId($id)
      ->chunk(1000, function ($logs)  use ($writer) {
        foreach($logs as $log) {
          $logs_data = [
            $log->drip_name,
            $log->email,
            $log->list,
            $log->sending_server,
            $log->message_id,
            $log->status,
            Helper::datetimeDisplay($log->created_at),
          ];

          // Write bounce data
          $writer->insertOne($logs_data);
        }
    });
  }
}
