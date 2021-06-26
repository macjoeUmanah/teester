<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomField;
use App\Rules\UniqueCustomField;
use Auth;
use Helper;

class CustomFieldController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('custom_fields'); // check user permission
    $page = 'list_custom_fields'; // choose sidebar menu option
    return view('custom_fields.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getCustomFields(Request $request) {
    $result = CustomField::select('id', 'name', 'type', 'required', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'name', 'type', 'required', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $custom_fields = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($custom_fields as $custom_field) {
      $checkbox = "<input type=\"checkbox\" value=\"{$custom_field->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('custom_field.edit', ['id' => $custom_field->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$custom_field->id.'\', \''.route('custom_field.destroy', ['id' => $custom_field->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$custom_field->id}",
        $checkbox,
        $custom_field->id,
        $custom_field->name,
        $custom_field->type,
        Helper::datetimeDisplay($custom_field->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create() {
    Helper::checkPermissions('custom_fields'); // check user permission
    $custom_field_type = $this->customFieldTypes();
    $multiselect = !empty(\Input::get('multiselect')) ? \Input::get('multiselect') : 0;
    return view('custom_fields.create')->with(compact('custom_field_type', 'multiselect'));
  }

  /**
   * Save data
  */
  public function store(Request $request) {
    $request->validate([
      'name' => ['required', 'string', new UniqueCustomField],
    ]);
    $data = $this->customFiedlData($request);
    $custom_field = CustomField::create($data);
    if(!empty($data['list_ids'])) {
      $list_ids = array_values($data['list_ids']);
      $custom_field->lists()->attach($list_ids);
    }
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.custom_field') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id) {
    Helper::checkPermissions('custom_fields'); // check user permission
    $custom_field = CustomField::whereId($id)->app()->first();
    $custom_field_lists = $custom_field->getListId()->toArray();
    $custom_field_type = $this->customFieldTypes();
    return view('custom_fields.edit')->with(compact('custom_field', 'custom_field_type', 'custom_field_lists'));
  }

  /**
   * Update data
  */
  public function update(Request $request, $id) {
    $request->validate([
      'name' => 'required|string'
    ]);
    $custom_field = CustomField::findOrFail($id);
    $data = $this->customFiedlData($request);
    $custom_field->fill($data)->save();
    if(!empty($data['list_ids'])) {
      $list_ids = array_values($data['list_ids']);
      $custom_field->lists()->sync($list_ids);
    }
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.custom_field') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function customFiedlData($request) {
    $input = $request->except('_token');
    $input['values'] = !empty($input['values']) ? $input['values'] : null;
    $input['tag'] = str_slug($input['name'], '-');
    $input['required'] = !empty($input['required']) ? 'Yes' : 'No';
    $list_ids = !empty($input['list_ids']) ? array_values($input['list_ids']) : null;
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    return $input;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request) {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(CustomField::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = CustomField::whereIn('id', $ids)->delete();
    } else {
      $names = CustomField::whereId($id)->value('name');
      $destroy = CustomField::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.custom_field') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Return custom fields types
  */
  public function customFieldTypes() {
    return [
      'text' => 'Text Field',
      'number' => 'Number Field',
      'textarea' => 'Textarea',
      'date'  => 'Date Field',
      'radio' => 'Radio Buttons',
      'checkbox' => 'Checkboxes',
      'dropdown' => 'Dropdown'
    ];
  }
}
