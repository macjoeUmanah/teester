<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spintag;
use Auth;
use Helper;

class SpintagController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('spintags'); // check user permission
    $page = 'automation_spintags'; // choose sidebar menu option
    return view('spintags.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getSpintags(Request $request)
  {
    $result = Spintag::select('id', 'name', 'values', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'name', 'values', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $spintags = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($spintags as $spintag) {
      $checkbox = "<input type=\"checkbox\" value=\"{$spintag->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('spintag.edit', ['id' => $spintag->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$spintag->id.'\', \''.route('spintag.destroy', ['id' => $spintag->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$spintag->id}",
        $checkbox,
        $spintag->name,
        Helper::datetimeDisplay($spintag->created_at),
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
    Helper::checkPermissions('spintags'); // check user permission
    return view('spintags.create');
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:spintags|string|max:255'
    ]);
    $data = $this->spintagData($request);
    Spintag::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.spintag') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('spintags'); // check user permission
    $spintag = Spintag::whereId($id)->app()->first();
    return view('spintags.edit')->with(compact('spintag'));
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255'
    ]);
    $spintag = Spintag::findOrFail($id);
    $data = $this->spintagData($request);
    $spintag->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.spintag') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function spintagData($request) {
    $input = $request->except('_token');
    $input['values'] = !empty($input['values']) ? $input['values'] : null;
    $input['tag'] = str_slug($input['name'], '-');
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
      $names = json_encode(array_values(Spintag::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = Spintag::whereIn('id', $ids)->delete();
    } else {
      $names = Spintag::whereId($id)->value('name');
      $destroy = Spintag::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.broadcast') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
