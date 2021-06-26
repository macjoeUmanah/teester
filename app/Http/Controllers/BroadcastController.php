<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BroadcastRequest;
use App\Models\Broadcast;
use Auth;
use Helper;

class BroadcastController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('broadcasts'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.broadcasts'));
    $page = 'campaign_broadcasts'; // choose sidebar menu option
    return view('broadcasts.index')->with(compact('page', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getBroadcasts(Request $request)
  {
    $result = Broadcast::join('groups', 'groups.id', '=', 'broadcasts.group_id')
      ->select('broadcasts.id', 'broadcasts.name as name', 'broadcasts.created_at', 'groups.id as group_id', 'groups.name as group_name')
      ->where('broadcasts.app_id', Auth::user()->app_id);
    
    $columns = ['broadcasts.id', 'broadcasts.id', 'broadcasts.name', 'groups.name', 'broadcasts.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $broadcasts = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($broadcasts as $broadcast) {
      $checkbox = "<input type=\"checkbox\" value=\"{$broadcast->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('broadcast.show', ['id' => $broadcast->id]).'\')"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="'.route('broadcast.edit', ['id' => $broadcast->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('broadcast.copy', ['id' => $broadcast->id]).'"><i class="fa fa-copy"></i>'.__('app.make_a_copy').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="move(\''.$broadcast->id.'\', \''.htmlentities($broadcast->name).'\')"><i class="fa fa-arrows"></i>'.__('app.move').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('send.email', ['campaign_id' => $broadcast->id, 'sending_server_id' => 0, 'template_id' => 0]).'\')"><i class="fa fa-send-o"></i>'.__('app.send_test_email').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$broadcast->id.'\', \''.route('broadcast.destroy', ['id' => $broadcast->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';

      $group_name = "<span id='{$broadcast->group_id}'>$broadcast->group_name<span>";
      $data['data'][] = [
        "DT_RowId" => "row_{$broadcast->id}",
        $checkbox,
        $broadcast->id,
        '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('broadcast.show', ['id' => $broadcast->id]).'\')">'.$broadcast->name.'</a>',
        $group_name,
        Helper::datetimeDisplay($broadcast->created_at),
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
    Helper::checkPermissions('broadcasts'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.broadcasts'));
    $page = 'campaign_create_broadcasts'; // choose sidebar menu option
    $html = '';
    if(!empty(\Input::get('tid'))) {
      $html = \App\Models\Template::whereId(base64_decode(\Input::get('tid')))->value('content');
    }
    return view('broadcasts.create')->with(compact('page', 'groups', 'html'));
  }

  /**
   * Save data
  */
  public function store(BroadcastRequest $request)
  {
    $data = $this->broadcastData($request);
    Broadcast::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.broadcast') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('broadcasts'); // check user permission
    $broadcast = Broadcast::whereId($id)->app()->first();
    $groups = \App\Models\Group::groups(config('mc.groups.broadcasts'));
    $page = 'campaign_broadcasts'; // choose sidebar menu option
    return view('broadcasts.edit')->with(compact('page', 'broadcast', 'groups'));
  }

  /**
   * Update data
  */
  public function update(BroadcastRequest $request, $id)
  {
    $data = $this->broadcastData($request);
    $broadcast = Broadcast::findOrFail($id);
    $broadcast->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.broadcast') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function broadcastData($request)
  {
    $input = $request->except('_token');
    $sanitizer = new \Phlib\XssSanitizer\Sanitizer();
    $input['content_html'] = $sanitizer->sanitize($input['content_html']);
    $input['content_text'] = $sanitizer->sanitize($input['content_text']);
    $input['app_id'] = Auth::user()->app_id;
    $input['user_id'] = Auth::user()->id;
    return $input;
  }

  /**
   * Retrun broadcast view
  */
  public function show($id)
  {
    Helper::checkPermissions('broadcasts'); // check user permission
    $broadcast = Broadcast::whereId($id)->app()->first();
    return view('broadcasts.view')->with('broadcast', $broadcast);
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Broadcast::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Broadcast::whereIn('id', $ids)->delete();
    } else {
      $names = Broadcast::whereId($id)->value('name');
      $destroy = Broadcast::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.broadcast') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Retrun index after copy broadcast
  */
  public function copy($id)
  {
    $broadcast = Broadcast::whereId($id)->app()->first();
    $broadcast->name = $broadcast->name .' - copy ';
    $broadcast = $broadcast->replicate();
    $broadcast->save();
    session()->flash('msg', trans('app.msg_successfully_copied'));
    return redirect(route('broadcasts.index'));
  }
}
