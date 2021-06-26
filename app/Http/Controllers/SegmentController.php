<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;
use Auth;
use Helper;

class SegmentController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('segments'); // check user permission
    $page = 'automation_segments'; // choose sidebar menu option
    return view('segments.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getSegments(Request $request) {
    $result = Segment::select('id', 'name', 'type', 'action', 'total', 'processed', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'name', 'type', 'action', 'total', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $segments = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($segments as $segment) {
      $checkbox = "<input type=\"checkbox\" value=\"{$segment->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="'.route('segment.edit', ['id' => $segment->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';

      if($segment->action != 'Keep Copying' && $segment->action != 'Keep Moving') {
        if($segment->type == 'List') {
          $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('segment.action', ['id' => $segment->id, 'action' => 'Move']).'\')"><i class="fa fa-arrows"></i>'.__('app.move').'</a></li>';
          $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('segment.action', ['id' => $segment->id, 'action' => 'Keep Moving']).'\')"><i class="fa fa-arrows"></i>'.__('app.keep_moving').'</a></li>';
        }

        $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('segment.action', ['id' => $segment->id, 'action' => 'Copy']).'\')"><i class="fa fa-copy"></i>'.__('app.copy').'</a></li>';
        $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('segment.action', ['id' => $segment->id, 'action' => 'Keep Copying']).'\')"><i class="fa fa-copy"></i>'.__('app.keep_copying').'</a></li>';
        $actions .= '<li><a href="javascript:;" onclick="segmentExport(\''.route('segment.update.action', ['id' => $segment->id]).'\')"><i class="fa fa-upload"></i>'.__('app.export').'</a></li>';
      } else {
        $actions .= '<li><a href="javascript:;" onclick="segmentStop(\''.route('segment.update.action', ['id' => $segment->id]).'\')"><i class="fa fa-stop-circle-o"></i>'.__('app.stop_segment').'</a></li>';
      }
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$segment->id.'\', \''.route('segment.destroy', ['id' => $segment->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';

      $progress = "( {$segment->processed} / {$segment->total} ) " . Helper::getPercnetage($segment->processed, $segment->total);
      $action = empty($segment->action) ? '---' : $segment->action . " $progress";
      $data['data'][] = [
        "DT_RowId" => "row_{$segment->id}",
        $checkbox,
        $segment->name,
        $segment->type,
        $segment->total,
        $action,
        Helper::datetimeDisplay($segment->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create($by)
  {
    Helper::checkPermissions('segments'); // check user permission
    $page = 'automation_segments';
    if($by == 'list') {
      $custom_fields = $this->customFields();
      $custom_fields_date = $this->customFields('=');
      return view('segments.create_list')->with(compact('page', 'by', 'custom_fields', 'custom_fields_date'));
    } else {
      return view('segments.create_campaign')->with(compact('page', 'by'));
    }
  }

  /**
   * Save data
  */
  public function store (Request $request)
  {
    $data = $this->segmentData($request);
    Segment::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('segments'); // check user permission
    $page = 'automation_segments';
    $segment = Segment::whereId($id)->app()->first();

    if($segment->type == 'List') {
      $by = 'list';
      $custom_fields = $this->customFields();
      $custom_fields_date = $this->customFields('=');
      return view('segments.edit_list')->with(compact('page', 'segment', 'custom_fields', 'custom_fields_date', 'by'));
    } else {
      $by = 'campaign';
      return view('segments.edit_campaign')->with(compact('page', 'segment', 'by'));
    }
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
    $data = $this->segmentData($request);
    $segment = Segment::findOrFail($id);
    $segment->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Get cutom fields without dates or only dates
  */
  private function customFields($without_dates = '!=')
  {
    $custom_fields = \App\Models\CustomField::select('id', 'name')
        ->whereAppId(\Auth::user()->app_id)
        ->where('type', $without_dates, 'date')
        ->get();
    return $custom_fields;
  }

  /**
   * Retrun data for store or update
  */
  public function segmentData($request) {
    if($request->method() == 'POST') {
      $request->validate([
        'name' => 'required|unique:segments|string|max:255',
      ]);
    } else {
      $request->validate([
        'name' => 'required|string|max:255',
      ]);
    }

    $request->validate([
      'list_ids' => 'required_if:type,==,list',
      'schedule_campaign_stat_ids' => 'required_if:type,==,campaign',
    ]);
    $input = $request->except('_token');
    $input['attributes'] = json_encode($input);
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
      $names = json_encode(array_values(Segment::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Segment::whereIn('id', $ids)->delete();
    } else {
      $names = Segment::whereId($id)->value('name');
      $destroy = Segment::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Set to Copy / Move action
  */
  public function action(Request $request, $id, $action=null)
  {
    Helper::checkPermissions('segments'); // check user permission
    if($request->method() == 'PUT') {
      $data['list_id_action'] = !empty($request->list_id) ? $request->list_id : NULL;
      $data['action'] = $request->action ?? null;
      $data['processed'] = 0;
      $data['is_running'] = 0;
      $segment = Segment::findOrFail($id);
      $segment->fill($data)->save();

      if($data['action'] == 'Copy' || $data['action'] == 'Keep Copying') {
        activity($data['action'])->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$segment->name}) ". __('app.log_segment_copy')); // log
        echo __('app.msg_copy_segment');
      } elseif($data['action'] == 'Move' || $data['action'] == 'Keep Moving') {
        activity($data['action'])->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$segment->name}) ". __('app.log_segment_move')); // log
        echo __('app.msg_move_segment');
      } elseif($data['action'] == 'Export') {
        activity($data['action'])->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.segment') . " ({$segment->name}) ". __('app.log_export')); // log
        echo __('app.msg_export_segment');
      }
    } elseif($request->method() == 'GET') {
      return view('segments.copy_move')->with(compact('id', 'action'));
    }
  }

  public function getAttributes($action, $segment_action, $scheduled_ids=null, $id=null)
  {
    $segment = null;
    if(!empty($id)) {
      $segment = Segment::whereId($id)->app()->first();
    }
    return view('segments.attributes')->with(compact('action', 'segment_action', 'scheduled_ids', 'segment'));
  }
}
