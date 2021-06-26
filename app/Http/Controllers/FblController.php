<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FblRequest;
use App\Models\Fbl;
use Auth;
use Helper;
use Crypt;

class FblController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('fbl'); // check user permission
    $page = 'setup_fbl'; // choose sidebar menu option
    return view('fbls.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getFbls(Request $request)
  {
    $result = Fbl::select('id', 'email', 'host', 'method', 'active', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'id', 'email', 'host', 'method', 'active', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $fbls = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($fbls as $fbl) {
      $checkbox = "<input type=\"checkbox\" value=\"{$fbl->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('fbl.edit', ['id' => $fbl->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a  class="text-red" href="javascript:;" onclick="destroy(\''.$fbl->id.'\', \''.route('fbl.destroy', ['id' => $fbl->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$fbl->id}",
        $checkbox,
        $fbl->id,
        $fbl->email,
        $fbl->host,
        $fbl->method,
        $fbl->active,
        Helper::datetimeDisplay($fbl->created_at),
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
    Helper::checkPermissions('fbl'); // check user permission
    return view('fbls.create');
  }

  /**
   * Save data
  */
  public function store(FblRequest $request)
  {
    $data = $this->fblData($request);
    Fbl::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.fbl') . " ({$request->email}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id) {
    Helper::checkPermissions('fbl'); // check user permission
    $fbl = Fbl::whereId($id)->app()->first();
    return view('fbls.edit')->with(compact('fbl'));
  }

  /**
   * Update data
  */
  public function update(FblRequest $request, $id) {
    $fbl = Fbl::findOrFail($id);
    $data = $this->fblData($request);
    $fbl->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.fbl') . " ({$fbl->email}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function fblData($request) {
    $input = $request->except('_token');
    $input['password'] = !empty($request->password) ? Crypt::encrypt($request->password) : null;
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
      $names = json_encode(array_values(Fbl::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = Fbl::whereIn('id', $ids)->delete();
    } else {
      $names = Fbl::whereId($id)->value('email');
      $destroy = Fbl::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.fbl') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
    
}
