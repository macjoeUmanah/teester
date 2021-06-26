<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lists;
use Helper;

class ListController extends Controller
{
  /**
   * Retrun a list detail
  */
  public function get(Request $request, $id)
  {
    $list = Lists::whereId($id)
      ->whereAppId($request->user('api')->app_id)
      ->with('group')
      ->with('customFields')
      ->with('sendingServer')
      ->first();

    if(!empty($list)) {
      if(!empty($list->customFields)) {
        $custom_fields = [];
        foreach($list->customFields as $custom_field) {
          array_push($custom_fields, $custom_field->name);
        }
      } else {
        $custom_fields = 'None';
      }
      $data = [
        'id' => $list->id,
        'name' => $list->name,
        'group_id' => $list->group->id,
        'group_name' => $list->group->name,
        'custom_fields' => $custom_fields,
        'sending_server' => $list->sendingServer->name,
        'sending_server_id' => $list->sendingServer->id,
        'double_optin' => $list->double_optin,
        'welcome_email' => $list->welcome_email,
        'notification' => $list->notification,
        'notification_email' => !empty($list->notification_attributes) ? json_decode($list->notification_attributes)->email : '',
        'created_at' => \Helper::datetimeDisplay($list->created_at)
      ];
      $status = __('app.success');
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Retrun lists
  */
  public function getLists(Request $request)
  {
    $result = Lists::whereAppId($request->user('api')->app_id)->with('group')
      ->with('customFields')
      ->with('sendingServer');

    if(!empty($request->group_id))
      $result->whereGroupId($request->group_id);

    if(!empty($request->start_from))
      $result->offset($request->start_from);

    $data = $result->limit(500)->get();
    return Helper::apiReturn(__('app.success'), $data);
  }

  /**
   * Add a list 
  */
  public function add(Request $request)
  { 
    $input = $this->listData($request);

    $status = __('app.error');
    if(empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif(empty($input['group_id'])) {
      $data = [
        'message' => 'group_id' . __('app.is_required'),
      ];
    } elseif(empty($input['sending_server_id'])) {
      $data = [
        'message' => 'sending_server_id' . __('app.is_required'),
      ];
    } else {
      if(!\App\Models\Group::whereId($input['group_id'])->whereAppId($input['app_id'])->whereTypeId(config('mc.groups.lists'))->exists()) {
        $data = [
          'message' => 'group_id' . __('app.not_exist'),
        ];
      } elseif(!\App\Models\sendingServer::whereId($input['sending_server_id'])->whereAppId($input['app_id'])->exists()) {
        $data = [
          'message' => 'sending_server_id' . __('app.not_exist'),
        ];
      } else {
        $list = Lists::whereAppId($input['app_id'])->whereName($input['name'])->whereGroupId($input['group_id'])->select('id')->first();
        if(!empty($list->id)) {
          $data = [
            'id' => $list->id,
            'message' => __('app.list') . __('app.already_exist'),
          ];
        } else {
          try {
            $list = Lists::create($input);
            $input['id'] = $list->id;

            // Attach custom fields for list
            if(!empty($input['custom_field_id'])) {
              $custom_field_ids = array_values($input['custom_field_id']);
              $list->customFields()->attach($custom_field_ids);
            }

            activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.list') . " ({$input['name']}) ". __('app.log_create')); // log

            $status = __('app.success');
            $data = [
              'id' => $list->id,
              'name' => $input['name']
            ];
          } catch (\Exception $e) {
            $data = [
              'message' => null,
            ];
          }
        }
      }
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Update a list 
  */
  public function update(Request $request, $id)
  {
    $input = $this->listData($request);

    $status = __('app.error');
    $data = [];
    if($request->name && empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif($request->group_id && empty($input['group_id'])) {
      $data = [
        'message' => 'group_id' . __('app.is_required'),
      ];
    } elseif($request->sending_server_id && empty($input['sending_server_id'])) {
      $data = [
        'message' => 'sending_server_id' . __('app.is_required'),
      ];
    } else {
      if($request->group_id && !\App\Models\Group::whereId($input['group_id'])->whereAppId($input['app_id'])->whereTypeId(config('mc.groups.lists'))->exists()) {
        $data = [
          'message' => 'group_id' . __('app.not_exist'),
        ];
      } elseif($request->sending_server_id && !\App\Models\sendingServer::whereId($input['sending_server_id'])->whereAppId($input['app_id'])->exists()) {
        $data = [
          'message' => 'sending_server_id' . __('app.not_exist'),
        ];
      } else {
        try {
          $list = Lists::findOrFail($id);
          $input['name'] = empty($input['name']) ? $list->name : $input['name'];
          $input['group_id'] = empty($input['group_id']) ? $list->group_id : $input['group_id'];
          $input['sending_server_id'] = empty($input['sending_server_id']) ? $list->sending_server_id : $input['sending_server_id'];
          $input['notification'] = empty($input['notification']) ? $list->notification : $input['notification'];
          $input['notification_criteria'] = empty($input['notification_criteria']) ? $list->notification_criteria : $input['notification_criteria'];
          $input['notification_attributes'] = empty($input['notification_attributes']) ? $list->notification_attributes : $input['notification_attributes'];
          $list->fill($input)->save();

          activity('update')->withProperties(['app_id' => $input['app_id']])->log(__('app.list') . " ({$input['name']}) ". __('app.log_update')); 

          $status = __('app.success');
          $data = [
            'id' => $list->id,
            'message' => __('app.list') .' '. __('app.log_update'),
          ];
        } catch (\Exception $e) {
          $data = [
            'message' => null,
          ];
        }
      }
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Return inputed data
  */
  public function listData($request)
  {
    $input = $request->all();
    $input['name'] = !empty($input['name']) ? trim($input['name']) : null;
    $input['group_id'] = !empty($input['group_id']) ? trim($input['group_id']) : null;
    $input['sending_server_id'] = !empty($input['sending_server_id']) ? trim($input['sending_server_id']) : null;
    $input['notification'] = !empty($input['notification']) ? $input['notification'] : null;
    $input['notification_criteria'] = !empty($input['notification_criteria']) ? $input['notification_criteria'] : null;
    $input['notification_attributes'] = $input['notification'] == 'Enabled' ? json_encode(['email'=>$input['notification_email'], 'criteria'=>$input['notification_criteria']]) : null;

    $input['user_id'] = $request->user('api')->id;
    $input['app_id'] = $request->user('api')->app_id;
    return $input;
  }

  /**
   * Delete a list 
  */
  public function delete(Request $request, $id)
  {
    $name = Lists::whereAppId($request->user('api')->app_id)->whereId($id)->value('name');

    if(!empty($name)) {
      $destroy = Lists::destroy($id);
      activity('delete')->withProperties(['app_id' => $request->user('api')->app_id])->log(__('app.list') . " ({$name}) ". __('app.log_delete'));

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
