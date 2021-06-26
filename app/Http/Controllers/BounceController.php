<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BounceRequest;
use App\Models\Bounce;
use Auth;
use Helper;
use Crypt;

use Webklex\IMAP\Client;

class BounceController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('bounces'); // check user permission
    $page = 'setup_bounces'; // choose sidebar menu option
    return view('bounces.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getBounces(Request $request)
  {
    $result = Bounce::select('id', 'email', 'host', 'method', 'active', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'id', 'email', 'host', 'method', 'active', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $bounces = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($bounces as $bounce) {
      $checkbox = "<input type=\"checkbox\" value=\"{$bounce->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('bounce.edit', ['id' => $bounce->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$bounce->id.'\', \''.route('bounce.destroy', ['id' => $bounce->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$bounce->id}",
        $checkbox,
        $bounce->id,
        $bounce->email,
        $bounce->host,
        $bounce->method,
        $bounce->active,
        Helper::datetimeDisplay($bounce->created_at),
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
    Helper::checkPermissions('bounces'); // check user permission
    return view('bounces.create');
  }

  /**
   * Save data
  */
  public function store(BounceRequest $request)
  {
    $data = $this->bounceData($request);
    Bounce::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.bounce') . " ({$request->email}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('bounces'); // check user permission
    $bounce = Bounce::whereId($id)->app()->first();
    return view('bounces.edit')->with(compact('bounce'));
  }

  /**
   * Update data
  */
  public function update(BounceRequest $request, $id)
  {
    $bounce = Bounce::findOrFail($id);
    $data = $this->bounceData($request);
    $bounce->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.bounce') . " ({$bounce->email}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function bounceData($request)
  {
    $input = $request->except('_token');
    $input['password'] = !empty($request->password) ? Crypt::encrypt($request->password) : null;
    $input['active'] = !empty($request->active) ? 'Yes' : 'No';
    $input['app_id'] = Auth::user()->app_id;
    $input['user_id'] = Auth::user()->id;
    return $input;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Bounce::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = Bounce::whereIn('id', $ids)->delete();
    } else {
      $names = Bounce::whereId($id)->value('email');
      $destroy = Bounce::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.bounce') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Return after validate for IMAP or POP3
  */
  public function validateImap(Request $request)
  {
    $validate_cert = $request->validate_cert == 'Yes' ? true : false;
    $oClient = new Client([
      'host'          => $request->host,
      'port'          => $request->port,
      'encryption'    => $request->encryption,
      'validate_cert' => $validate_cert,
      'username'      => $request->username,
      'password'      => $request->password,
      'protocol'      => $request->method     // imap or pop3
    ]);
    try {
      $oClient->connect();
      return '<span class="text-success">'.__('app.msg_successfully_connected').'</span>';
    } catch(\Exception $e) {
      $msg = $e->getMessage();
      return "<span class='text-danger'>{$msg}</span>";
    }
  }
}
