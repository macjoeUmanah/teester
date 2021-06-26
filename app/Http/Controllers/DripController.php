<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DripRequest;
use App\Models\Drip;
use Auth;
use Helper;

class DripController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('drips'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.drips'));
    $page = 'automation_drips'; // choose sidebar menu option
    return view('drips.index')->with(compact('page', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getDrips(Request $request)
  {
    $result = Drip::join('groups', 'drips.group_id', '=', 'groups.id')
      ->join('broadcasts', 'drips.broadcast_id', '=', 'broadcasts.id')
      ->select('drips.id', 'drips.name as name', 'drips.send', 'drips.after_minutes', 'drips.created_at', 'groups.id as group_id', 'groups.name as group_name', 'broadcasts.name as broadcast_name', 'broadcasts.id as broadcast_id')
      ->where('drips.app_id', Auth::user()->app_id);
    
    $columns = ['drips.id', 'drips.name', 'groups.name', 'broadcasts.name', 'drips.after_minutes', 'drips.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $drips = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($drips as $drip) {
      $checkbox = "<input type=\"checkbox\" value=\"{$drip->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">';

          $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('drip.edit', ['id' => $drip->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
          $actions .= '<li><a href="javascript:;" onclick="move(\''.$drip->id.'\', \''.htmlentities($drip->name).'\')"><i class="fa fa-arrows"></i>'.__('app.move').'</a></li>';
          $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$drip->id.'\', \''.route('drip.destroy', ['id' => $drip->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';

      $actions .= '</ul></div>';

      $group_name = "<span id='{$drip->group_id}'>$drip->group_name<span>";
      $send = $drip->send;
      if($send == 'After') {
        if($drip->after_minutes >= 1440) {
          // 1440 = 1 Day;
          $time = round($drip->after_minutes / 1440, 2);
          $duration = __('app.days');
        } elseif($drip->after_minutes >= 60) {
          // 60 = 1 Hour;
          $time = round($drip->after_minutes / 60, 2);
          $duration = __('app.hours');
        } else {
          $time = $drip->after_minutes;
          $duration = __('app.minutes');
        }
        $send = "{$drip->send}  $time $duration";
      }
      
      if(!empty($drip->broadcast_name)) {
        $broadcast_name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('broadcast.show', ['id' => $drip->broadcast_id]).'\')">'.$drip->broadcast_name.'</a>';
      } else {
        $broadcast_name = '---';
      }
      $data['data'][] = [
        "DT_RowId" => "row_{$drip->id}",
        $checkbox,
        $drip->name,
        $group_name,
        $broadcast_name,
        $send,
        Helper::datetimeDisplay($drip->created_at),
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
    Helper::checkPermissions('drips'); // check user permission
    return view('drips.create');
  }

  /**
   * Save data
  */
  public function store(DripRequest $request)
  {
    $data = $this->dripData($request);
    Drip::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.drip') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('drips'); // check user permission
    $drip = Drip::whereId($id)->app()->first();
    return view('drips.edit')->with(compact('drip'));
  }

  /**
   * Update data
  */
  public function update(DripRequest $request, $id)
  {
    $drip = Drip::findOrFail($id);
    $data = $this->dripData($request);
    $drip->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.drip') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function dripData($request)
  {
    $input = $request->except('_token');
    $input['active'] = !empty($request->active) ? 'Yes' : 'No';
    $input['send_attributes'] = json_encode(['send'=>$input['send'], 'time'=>$input['time'], 'duration'=>$input['duration']]);
    if($input['send'] == 'After') {
      if($input['duration'] == 'hours') {
        // Convet hours into minutes
        $input['after_minutes'] = $input['time'] * 60;
      } elseif($input['duration'] == 'days') {
        // Convet days into minutes; 1 Day = 60*24 = 1440
        $input['after_minutes'] = $input['time'] * 1440; 
      } else {
        $input['after_minutes'] = $input['time'];
      }
    } else {
      // For Instant
      $input['after_minutes'] = 0;
    }
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Drip::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Drip::whereIn('id', $ids)->delete();
    } else {
      $names = Drip::whereId($id)->value('name');
      $destroy = Drip::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.setup_suppression') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
