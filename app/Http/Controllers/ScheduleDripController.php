<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleDripRequest;
use App\Models\ScheduleDrip;
use Auth;
use Helper;

class ScheduleDripController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('drips_schedules'); // check user permission
    $page = 'drips_schedules'; // choose sidebar menu option
    return view('schedule_drips.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getScheduledDrips(Request $request)
  {
    $result = ScheduleDrip::select('schedule_drips.id', 'schedule_drips.name', 'schedule_drips.drip_group_id', 'schedule_drips.status', 'schedule_drips.created_at', 'schedule_drip_stats.id as stat_id')
      ->leftJoin('schedule_drip_stats', 'schedule_drips.id', '=', 'schedule_drip_stats.schedule_drip_id')
      ->where('schedule_drips.app_id', Auth::user()->app_id)
      ->with('group');
    
    $columns = ['id', 'name', 'status', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $scheduled_drips = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($scheduled_drips as $schedule) {
      $checkbox = "<input type=\"checkbox\" value=\"{$schedule->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a href="'.route('schedule_drip.edit', ['id' => $schedule->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('detail.stat.drip', ['id' => $schedule->stat_id]).'" ><i class="fa fa-bar-chart"></i>'.__('app.stats').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$schedule->id.'\', \''.route('schedule_drip.destroy', ['id' => $schedule->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
          $actions .= '</ul></div>';

      $status = '';
      if($schedule->status == 'Running') {
        $status = "<a href='javascript:;'>
          <i class='fa fa-play-circle text-green' id='play-{$schedule->id}' title='".__('app.play')."' onclick='pause(\"{$schedule->id}\");' style='display:none;'></i>
          <i class='fa fa-pause-circle text-red' id='pause-{$schedule->id}' title='".__('app.pause')."' onclick='play(\"{$schedule->id}\");'></i>
          </a>";
      } elseif($schedule->status == 'Paused') {
        $status = "<a href='javascript:;'>
          <i class='fa fa-play-circle text-green' id='play-{$schedule->id}' title='".__('app.play')."' onclick='pause(\"{$schedule->id}\");'></i>
          <i class='fa fa-pause-circle text-red' id='pause-{$schedule->id}' title='".__('app.pause')."' onclick='play(\"{$schedule->id}\");' style='display:none;'></i>
          </a>";
      }
      $status .= " <span id='status-{$schedule->id}'>{$schedule->status}</span>";

      $data['data'][] = [
        "DT_RowId" => "row_{$schedule->id}",
        $checkbox,
        $schedule->name,
        $schedule->group->name,
        $status,
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
    Helper::checkPermissions('drips_schedules'); // check user permission
    $page = 'drips_schedules'; // choose sidebar menu option
    return view('schedule_drips.create')->with(compact('page'));
  }

  /**
   * Save data
  */
  public function store(ScheduleDripRequest $request)
  {
    $data = $this->scheduleDripData($request);
    $drip = ScheduleDrip::create($data);

    // Need to save data for drip stat also
    $this->saveDripStat($drip);
  }

  /**
  * Save data for drip stat
  */
  private function saveDripStat($drip) {
    //print_r($drip);
    $data['schedule_drip_id'] = $drip->id;
    $data['schedule_by'] = Auth::user()->name;
    $data['schedule_drip_name'] = $drip->name;
    $data['drip_group_name'] = \App\Models\Group::whereId($drip->drip_group_id)->value('name');
    $data['app_id'] = $drip->app_id;
    $data['user_id'] = $drip->user_id;
    \App\Models\ScheduleDripStat::create($data);
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('drips_schedules'); // check user permission
    $scheduled = ScheduleDrip::whereId($id)->app()->first();
    $page = 'drips_schedules'; // choose sidebar menu option
    return view('schedule_drips.edit')->with(compact('page', 'scheduled'));
  }

  /**
   * Update data
  */
  public function update(ScheduleDripRequest $request, $id)
  {
    $schedule = ScheduleDrip::findOrFail($id);
    $data = $this->scheduleDripData($request);
    $schedule->fill($data)->save();
  }

  /**
   * Retrun data for store or update
  */
  public function scheduleDripData($request)
  {
    $input = $request->except('_token');
    $input['list_ids'] = implode(',', $input['list_ids']);
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Update status
  */
  public function updateScheduleStatus(Request $request, $id)
  {
    ScheduleDrip::whereId($id)->update(['status' => $request->status]);
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(ScheduleDrip::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = ScheduleDrip::whereIn('id', $ids)->delete();
    } else {
      $names = ScheduleDrip::whereId($id)->value('name');
      $destroy = ScheduleDrip::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.broadcast') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
