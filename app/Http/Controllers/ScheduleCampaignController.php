<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleCampaignRequest;
use App\Models\ScheduleCampaign;
use Auth;
use Helper;

class ScheduleCampaignController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('campaigns'); // check user permission
    $page = 'campaign_schedules'; // choose sidebar menu option
    return view('schedule_campaigns.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getScheduledCampaigns(Request $request)
  {
    $result = ScheduleCampaign::select('schedule_campaigns.id', 'schedule_campaigns.name', 'schedule_campaigns.broadcast_id',
      'schedule_campaign_stats.start_datetime', 'schedule_campaigns.status', 'schedule_campaigns.total', 'schedule_campaigns.scheduled',
      'schedule_campaigns.sent', 'schedule_campaigns.created_at', 'schedule_campaigns.sending_server_ids', 'schedule_campaigns.sending_speed', 'schedule_campaign_stats.id as stats_id')
      ->leftJoin('schedule_campaign_stats', 'schedule_campaigns.id', '=', 'schedule_campaign_stats.schedule_campaign_id')
      ->where('schedule_campaigns.app_id', Auth::user()->app_id)
      ->with('broadcast');
    
    $columns = ['schedule_campaigns.id', 'schedule_campaigns.name', 'schedule_campaigns.id', 'schedule_campaign_stats.start_datetime', 'schedule_campaigns.id', 'schedule_campaigns.status','schedule_campaigns.total', 'schedule_campaigns.scheduled', 'schedule_campaigns.id', 'schedule_campaigns.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $total = $data['total'];
    $result = $data['result'];

    $scheduled_campaigns = $result->get();

    $data =  Helper::datatableTotals($total);

    foreach($scheduled_campaigns as $schedule) {
      $sending_speed = json_decode($schedule->sending_speed);
      $checkbox = "<input type=\"checkbox\" value=\"{$schedule->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu pull-right" role="menu">';
      $actions .= '<li><a href="javascript:;" onclick="reschedule(\''.$schedule->id.'\', \''.__('app.reschedule_campaing_msg'). '\')"><i class="fa fa-retweet"></i>'.__('app.reschedule').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.campaign', [$schedule->stats_id, 'summary', 'stats.campaigns.summary_popup']).'\')"><i class="fa fa-area-chart"></i>'.__('app.summary').'</a></li>';
      $actions .= '<li><a href="'.route('detail.stat.campaign', ['id' => $schedule->stats_id]).'" ><i class="fa fa-bar-chart"></i>'.__('app.stats').'</a></li>';
      if($schedule->status == 'RunningLimit' && !empty($sending_speed->limit)) {
        $actions .= '<li><a href="javascript:;" onclick="runLimitedToUnlimited(\''.$schedule->id.'\', \''.__('app.run_limited_to_unlmited_msg'). '\')" ><i class="fa fa-paper-plane-o"></i>'.__('app.run_as_unlimited').'</a></li>';
      }
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$schedule->id.'\', \''.route('schedule_campaign.destroy', ['id' => $schedule->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';

      $status = '';
      if($schedule->status == 'Running' || $schedule->status == 'RunningLimit' || $schedule->status == 'Resume') {
        $status = "<a href='javascript:;'>
          <i class='fa fa-play-circle text-green' id='play-{$schedule->id}' title='".__('app.play')."' onclick='pauseCampaign(\"{$schedule->id}\");' style='display:none;'></i>
          <i class='fa fa-pause-circle text-red' id='pause-{$schedule->id}' title='".__('app.pause')."' onclick='playCampaign(\"{$schedule->id}\");'></i>
          </a>";
        $schedule->status = 'Running'; // To overwrite RunningLimit to display
      } elseif($schedule->status == 'Paused') {
        $status = "<a href='javascript:;'>
          <i class='fa fa-play-circle text-green' id='play-{$schedule->id}' title='".__('app.play')."' onclick='pauseCampaign(\"{$schedule->id}\");'></i>
          <i class='fa fa-pause-circle text-red' id='pause-{$schedule->id}' title='".__('app.pause')."' onclick='playCampaign(\"{$schedule->id}\");' style='display:none;'></i>
          </a>";
      } elseif($schedule->status == 'System Paused') {
        $status = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('sending_server.status', ['id' => $schedule->sending_server_ids]).'\')"><i class="fa fa-info-circle text-red"></i></a>';
      }
      $status .= " <span id='status-{$schedule->id}'>{$schedule->status}</span>";

      $start_datetime = $schedule->status == 'Preparing' ? '---' : Helper::datetimeDisplay($schedule->start_datetime);

      $spinner = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
      $progress = "( {$schedule->sent} / {$schedule->scheduled} ) " . Helper::getPercnetage($schedule->sent, $schedule->scheduled);
      $scheduled = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('scheduled.detail.campaign', ['id' => $schedule->id]).'\')">'.$schedule->scheduled.'</a>';

      $name = $schedule->status == 'System Paused' ?  '<a href="javascript:;" onclick="swal(\''.$schedule->name.'\')"><i class="fa fa-info-circle text-red"></i></a> '.$schedule->name : $schedule->name;
      
      $limit = empty($sending_speed->limit) ? __('app.unlimited') : $sending_speed->limit;

      $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('schedule_campaign.show', ['id' => $schedule->id]).'\')">'.$schedule->name.'</a>';

      $broadcast_name = $schedule->broadcast->name ?? '---';
      $data['data'][] = [
        "DT_RowId" => "row_{$schedule->id}",
        $checkbox,
        $name,
        $broadcast_name,
        $start_datetime,
        $limit,
        $status,
        $schedule->total == null ? $spinner : $schedule->total,
        $schedule->scheduled == null ? $spinner : $scheduled,
        $schedule->total == null ? $spinner : $progress,
        Helper::datetimeDisplay($schedule->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create()
  {
    Helper::checkPermissions('campaigns'); // check user permission
    $page = 'campaign_schedules'; // choose sidebar menu option
    return view('schedule_campaigns.create')->with(compact('page'));
  }

  /**
   * Save data
  */
  public function store(ScheduleCampaignRequest $request)
  {
    $data = $this->scheduleCampaignData($request);
    $data['scheduled'] = 0;
    $schedule_campaign = ScheduleCampaign::create($data);

    activity('schedule')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.schedules') . " ({$request->name}) ". __('app.log_schedule')); // log
    \App\Jobs\CampaignPrepare::dispatch($schedule_campaign->id)
      ->delay(now()->addSeconds(10));
    \Artisan::call('queue:work', ['--once' => true]); // execute queue
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('campaigns'); // check user permission
    $scheduled = ScheduleCampaign::whereId($id)->app()->first();
    $page = 'campaign_schedules'; // choose sidebar menu option
    return view('schedule_campaigns.edit')->with(compact('page', 'scheduled'));
  }

  /**
   * Update data
  */
  public function update(ScheduleCampaignRequest $request, $id)
  {
    $schedule = ScheduleCampaign::findOrFail($id);
    $data = $this->scheduleCampaignData($request);
    $schedule->fill($data)->save();
    activity('schedule')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.schedules') . " ({$request->name}) ". __('app.log_update')); // log
    \App\Jobs\CampaignPrepare::dispatch($schedule->id)
      ->delay(now()->addSeconds(10));
    \Artisan::call('queue:work', ['--once' => true]); // execute queue
  }

  public function show($id)
  {
    $scheduled = ScheduleCampaign::whereId($id)->app()->first();
    return view('schedule_campaigns.view')->with(compact('scheduled'));
  }

  /**
   * Retrun data for store or update
  */
  public function scheduleCampaignData($request) {
    $input = $request->except('_token');
    $input['list_ids'] = implode(',', $input['list_ids']);
    $input['sending_server_ids'] = implode(',', $input['sending_server_ids']);

    $carbon = new \Carbon\Carbon();
    if($input['send'] == 'now') {
      $input['send_datetime'] = $carbon->now();
    } else {
      $send_datetime = date('Y-m-d H:i:s', strtotime("{$input['send_date']} {$input['send_time']}"));
      // Convert future datetime into UTC datetime
      $offsetSeconds =  $carbon->now(Auth::user()->time_zone)->getOffset();
      $input['send_datetime'] = \Carbon\Carbon::parse($send_datetime, config('app.timezone'))->subSeconds($offsetSeconds);
    }
    $input['sending_speed'] = json_encode(['speed'=>$input['speed'], 'limit'=>$input['limit'], 'duration'=>$input['duration']]);

    // For time limit the threads must be 1; no parallels sending required
    $input['threads'] = !empty($input['limit']) ? 1 : config('mc.threads');
    $input['thread_no'] = 1;
    $input['sent'] = 0;
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Return re-schedule view
  */
  public function reschedule($id) {
    Helper::checkPermissions('campaigns'); // check user permission
    $schedule = ScheduleCampaign::find($id);
    $schedule->name = $schedule->name .' - reschedule ';
    $schedule->total_threads = 0;
    $schedule->thread_no = 0;
    $schedule->total = 0;
    $schedule->scheduled = 0;
    $schedule->sent = 0;
    $schedule->scheduled_detail = null; 
    $schedule->status = 'Preparing';
    $schedule->user_id = Auth::user()->id;
    $scheduled = $schedule->replicate();
    $scheduled->save();
    activity('schedule')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.schedules') . " ({$schedule->name}) ". __('app.log_schedule')); // log
    return redirect(route('schedule_campaign.edit', ['id' => $scheduled->id]));
  }

  /**
   * Set campaing to run limited to unlimited.
  */
  public function limitedToUnlimited(Request $request) {
    $sending_speed = json_encode([
      'speed' => 'unlimited',
      'limit' => null,
      'duration'=> 'hour'
    ]);
    ScheduleCampaign::whereId($request->id)->update([
      'status' => 'Resume',
      'send_datetime' => \Carbon\Carbon::now(),
      'thread_no' => 1,
      'sending_speed' => $sending_speed,
      ]
    );

    // Update stat table also
    \App\Models\ScheduleCampaignStat::whereScheduleCampaignId($request->id)->update([
      'sending_speed' => $sending_speed,
      ]
    );
  }

  /**
   * Update status
  */
  public function updateScheduleStatus(Request $request, $id) {
    $status = $request->status;
    // For running status need to check either set to Running or RunningLimit(hourly)
    if($status == 'Resume') {
      $sending_speed = ScheduleCampaign::whereId($id)->value('sending_speed');
      if(json_decode($sending_speed)->limit) {
        $status = 'RunningLimit';
      }
    }
    ScheduleCampaign::whereId($id)->update(['status' => $status]);
  }

  /**
   * Retrurn view for scheduled detail
  */
  public function getScheduledDetail($id) {
    Helper::checkPermissions('campaigns'); // check user permission
    $schedule = ScheduleCampaign::findOrFail($id);
    $name = $schedule->name;
    $scheduled_detail = json_decode($schedule->scheduled_detail);
    return view('schedule_campaigns.scheduled_detail')->with(compact('name', 'scheduled_detail'));
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(ScheduleCampaign::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = ScheduleCampaign::whereIn('id', $ids)->delete();
    } else {
      $names = ScheduleCampaign::whereId($id)->value('name');
      $destroy = ScheduleCampaign::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.schedules') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Initiate send campaign process via scheduled command
  */
  public function processCampaign($id = null, $thread_no = 1)
  {
    if (!empty($id)) {
      $send = \Artisan::call('mc:process-campaign', [
        'id'        => $id,
        'thread_no' => $thread_no
      ]);
    } else {
      $schedules = ScheduleCampaign::whereIn('status', ['Scheduled', 'RunningLimit', 'Resume'])
        ->where('send_datetime', '<=', \Carbon\Carbon::now())
        ->orderBy('id', 'desc')
        ->get();
      if(count($schedules) > 0) {
        foreach($schedules as $schedule) {
          $this->processCampaignParallels($schedule);
        }
      }
    }
  }

  /**
   * Send parallel request to execute the campaign
  */
  public function processCampaignParallels($schedule)
  {
    $app_url = Helper::getAppURL();

    // Need to start thead_no with 1 instead 1 as default set 0
    $thread_no = $schedule->thread_no == 0 ? 1 : $schedule->thread_no;
    $threads = $thread_no + $schedule->threads;
    //$urls = [];
    // If set to send hourly then need to send only one thread with thread no
    if(json_decode($schedule->sending_speed)->limit) {
      $url = $app_url."/process_campaign/{$schedule->id}/{$thread_no}";
      //array_push($urls, $url);
      Helper::getUrl($url);
    } else  {
      for($i=$thread_no; $i<$threads; $i++) {
        $url = $app_url."/process_campaign/{$schedule->id}/{$i}";
        Helper::getUrl($url);
        //array_push($urls, $url);
      }
    }
    //Helper::parallelRequests($urls);
  }
}
