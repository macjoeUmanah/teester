<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Helper;

class CustomFieldController extends Controller
{
  /**
   * Retrun a custom field detail
  */
  public function get(Request $request, $id)
  {
    $custom_field = CustomField::whereId($id)->whereAppId($request->user('api')->app_id)->first();

    if(!empty($custom_field)) {
      $data = [
        'id' => $custom_field->id,
        'name' => $custom_field->name,
        'type' => $custom_field->type,
        'values' => Helper::splitLineBreakWithComma($custom_field->values),
        'created_at' => \Helper::datetimeDisplay($custom_field->created_at)
      ];
      $status = __('app.success');
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Retrun custom fields
  */
  public function getCustomFields(Request $request)
  {
    $result = CustomField::whereAppId($request->user('api')->app_id);

    if(!empty($request->start_from))
      $result->offset($request->start_from);

    $data = $result->limit(500)->get();
    return Helper::apiReturn(__('app.success'), $data);
  }

  /**
   * Add a custom field 
  */
  public function add(Request $request)
  {
    $input = $this->customFieldData($request);
    $input['values'] = !empty($request->value) ? $request->value : null;
    $input['type'] = !empty($request->type) ? $request->type : 'text';

    if(in_array($input['type'], ['radio', 'checkbox', 'dropdown'])) {
      $input['values'] = implode(',', $input['values']);
    }

    $status = __('app.error');
    if(empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } else {
      $custom_field = CustomField::whereAppId($input['app_id'])->whereName($input['name'])->select('id')->first();
      if(!empty($custom_field->id)) {
        $data = [
          'id' => $custom_field->id,
          'message' => __('app.custom_field') . __('app.already_exist'),
        ];
      } else {
        $custom_field = CustomField::create($input);
        activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.custom_field') . " ({$input['name']}) ". __('app.log_create')); // log

        $status = __('app.success');
        $data = [
          'id' => $custom_field->id,
          'name' => $input['name']
        ];
      }
    }
    return Helper::apiReturn($status, $data);
  }

  /**
   * Update a custom field 
  */
  public function update(Request $request, $id)
  {
    $input = $this->customFieldData($request);
    $status = __('app.error');
    $data = [];
    if($request->name && empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif($request->name) {
      CustomField::whereId($id)->whereAppId($input['app_id'])->update(['name' => $input['name']]);
      activity('update')->withProperties(['app_id' => $input['app_id']])->log(__('app.custom_field') . " ({$input['name']}) ". __('app.log_update')); // log
      $status = __('app.success');
      $data = [
        'id' => $id,
        'message' => __('app.custom_field') .' '. __('app.log_update'),
      ];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Return inputed data
  */
  public function customFieldData($request)
  {
    $input = $request->all();
    $input['name'] = !empty($input['name']) ? trim($input['name']) : null;
    $input['tag'] = str_slug($input['name'], '-');
    $input['required'] = !empty($input['required']) ? 'Yes' : 'No';
    $input['user_id'] = $request->user('api')->id;
    $input['app_id'] = $request->user('api')->app_id;
    return $input;
  }

  /**
   * Delete a custom field 
  */
  public function delete(Request $request, $id)
  {
    $name = CustomField::whereId($id)->whereAppId($request->user('api')->app_id)->value('name');
    if(!empty($name)) {
      $destroy = CustomField::destroy($id);
      activity('delete')->withProperties(['app_id' => $request->user('api')->app_id])->log(__('app.custom_field') . " ({$name}) ". __('app.log_delete'));

      $status = __('app.success');
      $data = [
        'id' => $id,
        'name' => $name
      ];
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }
    return Helper::apiReturn($status, $data);
  }
}
