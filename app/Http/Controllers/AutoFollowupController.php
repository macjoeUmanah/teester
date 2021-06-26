<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AutoFollowupRequest;
use App\Models\AutoFollowup;
use Auth;
use Helper;

class AutoFollowupController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('auto_followups'); // check user permission
    $page = 'automation_auto_followups'; // choose sidebar menu option
    return view('auto_followups.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getAutoFollowups(Request $request)
  {
    $result = AutoFollowup::join('broadcasts', 'auto_followups.broadcast_id', '=', 'broadcasts.id')
      ->join('segments', 'auto_followups.segment_id', '=', 'segments.id')
      ->select('auto_followups.id', 'auto_followups.name as name', 'auto_followups.active', 'auto_followups.created_at', 'broadcasts.name as broadcast_name',
        'segments.name as segment_name')
      ->where('auto_followups.app_id', Auth::user()->app_id);
    
    $columns = ['auto_followups.id', 'auto_followups.name', 'broadcasts.name', 'auto_followups.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $auto_followups = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($auto_followups as $auto_followup) {
      $checkbox = "<input type=\"checkbox\" value=\"{$auto_followup->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">';

          $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('auto_followup.edit', ['id' => $auto_followup->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
          $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$auto_followup->id.'\', \''.route('auto_followup.destroy', ['id' => $auto_followup->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';

      $actions .= '</ul></div>';

      $data['data'][] = [
        "DT_RowId" => "row_{$auto_followup->id}",
        $checkbox,
        $auto_followup->name,
        $auto_followup->segment_name,
        $auto_followup->broadcast_name,
        $auto_followup->active,
        Helper::datetimeDisplay($auto_followup->created_at),
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
    Helper::checkPermissions('auto_followups'); // check user permission
    return view('auto_followups.create');
  }

  /**
   * Save data
  */
  public function store(AutoFollowupRequest $request)
  {
    $data = $this->autoFollowupData($request);
    AutoFollowup::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.automation_auto_followups') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('auto_followups'); // check user permission
    $auto_followup = AutoFollowup::whereId($id)->app()->first();
    return view('auto_followups.edit')->with(compact('auto_followup'));
  }

  /**
   * Update data
  */
  public function update(AutoFollowupRequest $request, $id)
  {
    $auto_followup = AutoFollowup::findOrFail($id);
    $data = $this->autoFollowupData($request);
    $auto_followup->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.automation_auto_followups') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function autoFollowupData($request)
  {
    $input = $request->except('_token');
    $input['active'] = !empty($request->active) ? 'Yes' : 'No';
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
      $names = json_encode(array_values(AutoFollowup::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = AutoFollowup::whereIn('id', $ids)->delete();
    } else {
      $names = AutoFollowup::whereId($id)->value('name');
      $destroy = AutoFollowup::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.automation_auto_followups') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
