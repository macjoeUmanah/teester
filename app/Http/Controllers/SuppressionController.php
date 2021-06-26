<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppression;
use Auth;
use Helper;

class SuppressionController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('suppression'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.suppression'));
    $page = 'list_suppression'; // choose sidebar menu option
    return view('suppressions.index')->with(compact('page', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getSuppressions(Request $request)
  {
    $result = Suppression::join('groups', 'groups.id', '=', 'suppressions.group_id')
      ->leftJoin('lists', 'lists.id', '=', 'suppressions.list_id')
      ->select('suppressions.id', 'suppressions.email', 'suppressions.created_at', 'groups.id as group_id', 'groups.name as group_name', 'lists.name as list_name')
      ->where('suppressions.app_id', Auth::user()->app_id);

    $columns = ['suppressions.id', 'suppressions.email', 'groups.name', 'suppressions.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $suppressions = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($suppressions as $suppression) {
      $checkbox = "<input type=\"checkbox\" value=\"{$suppression->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$suppression->id.'\', \''.route('suppression.destroy', ['id' => $suppression->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $group_name = "<span id='{$suppression->group_id}'>$suppression->group_name<span>";
      $data['data'][] = [
        "DT_RowId" => "row_{$suppression->id}",
        $checkbox,
        $suppression->email,
        $group_name,
        $suppression->list_name,
        Helper::datetimeDisplay($suppression->created_at),
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
    Helper::checkPermissions('suppression'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.suppression'));
    return view('suppressions.create')->with('groups', $groups);
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
    $input = $request->except('_token');
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    $input['list_id'] = $request->based_on == 'list' ? $request->list_id : null;
    if($request->option == 'write') {
      $request->validate([
        'group_id' => 'required',
        'list_id' => 'required_if:based_on,==,list',
        'emails' => 'required'
      ]);
      $emails = Helper::splitLineBreakWithComma($input['emails']);
      foreach($emails as $email) {
        $input['email'] = trim($email);
        //if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
          Suppression::create($input);
       // }
      }
    } else {
      $request->validate([
        'file' => 'required|mimes:csv,txt|max:'.Helper::getMaxFileSizeMB(),
      ]);
      $file = $request->file('file');
      $reader = \League\Csv\Reader::createFromPath($file->getPathName(), 'r');
      $records = $reader->getRecords();
      foreach ($records as $offset => $record) {
        $input['email'] = trim($record[0]);
        //if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
          Suppression::create($input);
       // }
      }
    }
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(Suppression::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = Suppression::whereIn('id', $ids)->delete();
    } else {
      $names = Suppression::whereId($id)->value('email');
      $destroy = Suppression::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.setup_suppression') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }
}
