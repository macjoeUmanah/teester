<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Auth;
use Helper;

class PackageController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('packages'); // check user permission
    $page = 'user_management_packages'; // choose sidebar menu option
    return view('packages.index')->with(compact('page'));
  }


  /**
   * Retrun JSON datatable data
  */
  public function getPackages(Request $request)
  {
    $result = Package::where('app_id', Auth::user()->app_id);

    $columns = ['id', 'name', 'created_at', 'created_at', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $packages = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($packages as $package) {
      $checkbox = "<input type=\"checkbox\" value=\"{$package->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('package.edit', ['id' => $package->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$package->id.'\', \''.route('package.destroy', ['id' => $package->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $attributes = json_decode($package->attributes, true);
      $data['data'][] = [
        "DT_RowId" => "row_{$package->id}",
        $checkbox,
        $package->name,
        $attributes['no_of_recipients'] == -1 ? __('app.unlimited') : $attributes['no_of_recipients'],
        $attributes['no_of_sending_servers'] == -1 ? __('app.unlimited') : $attributes['no_of_sending_servers'],
        Helper::datetimeDisplay($package->created_at),
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
    Helper::checkPermissions('packages'); // check user permission
    return view('packages.create');
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
    ]);
    $input = $this->packageData($request->except('_token'));
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    $user = Package::create($input);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.package') . " ({$input['name']}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('packages'); // check user permission
    $package = Package::whereId($id)->app()->first();
    return view('packages.edit')->with(compact('package'));
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string',
    ]);
    $data = $this->packageData($request->except('_token'));
    $package = Package::findOrFail($id);
    $package->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.package') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Package data
  */

  private function packageData($input)
  {
    $list_ids = !empty($input['list_ids']) ? $input['list_ids'] : null;
    $sending_server_ids = !empty($input['sending_server_ids']) ? $input['sending_server_ids'] : null;
    $input['attributes'] = json_encode([
      'list_ids' => $list_ids,
      'sending_server_ids' => $sending_server_ids,
      'no_of_recipients' => $input['no_of_recipients'],
      'no_of_sending_servers' => $input['no_of_sending_servers']
    ]);
    return $input;
  }


  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Package::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Package::whereIn('id', $ids)->delete();
    } else {
      $names = Package::whereId($id)->value('name');
      $destroy = Package::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.package') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
