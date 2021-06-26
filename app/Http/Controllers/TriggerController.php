<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TriggerRequest;
use App\Models\Trigger;
use App\Models\ScheduleDripStat;
use Auth;
use Helper;

class TriggerController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('triggers'); // check user permission
    $page = 'automation_triggers'; // choose sidebar menu option
    return view('triggers.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getTriggers(Request $request)
  {
    $result = Trigger::where('app_id', Auth::user()->app_id)
      ->with('autoFollowupStat')
      ->with('scheduleDrip');
    
    $columns = ['id', 'name', 'execution_datetime', 'active', 'based_on', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $triggers = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($triggers as $trigger) {
      $checkbox = "<input type=\"checkbox\" value=\"{$trigger->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">';

      $actions .= '<li><a href="'.route('trigger.edit', ['id' => $trigger->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="restartTrigger(\''.$trigger->id.'\', \''.__('app.trigger_restart_msg').'\')"><i class="fa fa-refresh "></i>'.__('app.restart_trigger').'</a></li>';

      if($trigger->action == 'start_drip') {
        if(!empty($trigger->scheduleDrip->id)) {
          $schedule_drip_stat = ScheduleDripStat::whereScheduleDripId($trigger->scheduleDrip->id)->first();
          $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.drip', [$schedule_drip_stat->id, 'summary', 'stats.drips.summary_popup']).'\')">'.$trigger->name.'</a>';

          $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.drip', [$schedule_drip_stat->id, 'summary', 'stats.drips.summary_popup']).'\')"><i class="fa fa-area-chart"></i>'.__('app.summary').'</a></li>';
          $actions .= '<li><a href="'.route('detail.stat.drip', ['id' =>  $schedule_drip_stat->id]).'" ><i class="fa fa-bar-chart"></i>'.__('app.stats').'</a></li>';
        } else {
          $name = $trigger->name;
        }
      } else {
        if(!empty($trigger->autoFollowupStat->id)) {
          $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.auto_followup', [$trigger->autoFollowupStat->id, 'summary', 'stats.auto_followups.summary_popup']).'\')">'.$trigger->name.'</a>';

          $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.auto_followup', [$trigger->autoFollowupStat->id, 'summary', 'stats.auto_followups.summary_popup']).'\')"><i class="fa fa-area-chart"></i>'.__('app.summary').'</a></li>';
          $actions .= '<li><a href="'.route('detail.stat.auto_followup', ['id' => $trigger->autoFollowupStat->id]).'"><i class="fa fa-bar-chart"></i>'.__('app.stats').'</a></li>';
        } else {
          $name = $trigger->name;
        }
      }

      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$trigger->id.'\', \''.route('trigger.destroy', ['id' => $trigger->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';

      $actions .= '</ul></div>';

      $data['data'][] = [
        "DT_RowId" => "row_{$trigger->id}",
        $checkbox,
        $name,
        $trigger->based_on,
        Helper::datetimeDisplay($trigger->execution_datetime),
        $trigger->active,
        Helper::datetimeDisplay($trigger->created_at),
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
    Helper::checkPermissions('triggers'); // check user permission
    $page = 'automation_triggers'; // choose sidebar menu option
    return view('triggers.create')->with(compact('page'));
  }

  /**
   * Save data
  */
  public function store(TriggerRequest $request)
  {
    $data = $this->triggerData($request);
    Trigger::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.trigger') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('triggers'); // check user permission
    $trigger = Trigger::whereId($id)->app()->first();
    $page = 'automation_triggers'; // choose sidebar menu option
    return view('triggers.edit')->with(compact('page', 'trigger'));
  }

  /**
   * Update data
  */
  public function update(TriggerRequest $request, $id)
  {
    $trigger = Trigger::findOrFail($id);
    $data = $this->triggerData($request);
    $trigger->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.trigger') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function triggerData($request)
  {
    $input = $request->except('_token');
    $input['active'] = !empty($request->active) ? 'Yes' : 'No';
    $input['sending_server_ids'] = json_encode($request->sending_server_ids);
    $input['attributes'] = json_encode($input);
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;

    $carbon = new \Carbon\Carbon();
    if($input['execute'] == 'now') {
      $input['execution_datetime'] = $carbon->now();
    } else {
      $execution_datetime = date('Y-m-d H:i:s', strtotime("{$input['send_date_execute']} {$input['send_time_execute']}"));
      // Convert future datetime into UTC datetime
      $offsetSeconds =  $carbon->now(Auth::user()->time_zone)->getOffset();
      $input['execution_datetime'] = \Carbon\Carbon::parse($execution_datetime, config('app.timezone'))->subSeconds($offsetSeconds);
    }

    return $input;
  }

  /**
   * Retrun data according to based on 
  */
  public function getBasedOnData($type, $action, $id=null)
  {
    $trigger = null;
    if(!empty($id)) {
      $trigger = Trigger::whereId($id)->app()->first();
    }
    return view('triggers.based_on_data')->with(compact('type', 'action', 'trigger'));
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Trigger::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Trigger::whereIn('id', $ids)->delete();
    } else {
      $names = Trigger::whereId($id)->value('name');
      $destroy = Trigger::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.trigger') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Restart Trigger
  */
  public function restartTrigger($id)
  {
    Trigger::whereId($id)->update(['in_progress' => false]);
    return 1;
  }
}
