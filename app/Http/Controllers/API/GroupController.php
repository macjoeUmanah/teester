<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Helper;

class GroupController extends Controller
{
  /**
   * Retrun a group
  */
  public function get(Request $request, $id)
  {
    $group = Group::whereAppId($request->user('api')->app_id)->whereId($id)->first();

    if(!empty($group)) {
      $data = [
        'id' => $group->id,
        'name' => $group->name,
        'type_id' => $group->type_id,
        'created_at' => \Helper::datetimeDisplay($group->created_at)
      ];
      $status = __('app.success');
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Retrun groups
  */
  public function getGroups(Request $request)
  {
    $result = Group::whereAppId($request->user('api')->app_id)
      ->select('id', 'name', 'type_id', 'created_at');

    if(!empty($request->type_id))
      $result->whereTypeId($request->type_id);

    if(!empty($request->start_from))
      $result->offset($request->start_from);

    $data = $result->limit(500)->get();
    return Helper::apiReturn(__('app.success'), $data);
  }

  /**
   * Add a group
  */
  public function add(Request $request)
  {
    $input = $this->groupData($request);
    $input['type_id'] = !empty($request->type_id) ? $request->type_id : null;

    $status = __('app.error');
    if(empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif(empty($input['type_id'])) {
      $data = [
        'message' => 'type_id' . __('app.is_required'),
      ];
    } elseif(!in_array($input['type_id'],config('mc.groups'))) {
      $data = [
        'message' => 'type_id' . __('app.not_exist'),
      ];
    } else {
      $group = Group::whereAppId($input['app_id'])->whereTypeId($input['type_id'])->whereName($input['name'])->select('id')->first();
      if(!empty($group->id)) {
        $data = [
          'id' => $group->id,
          'message' => __('app.group') . __('app.already_exist'),
        ];
      } else {
        $group = Group::create($input);
        activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.group') . " ({$input['name']}) ". __('app.log_create')); // log

        $status = __('app.success');
        $data = [
          'id' => $group->id,
          'name' => $input['name']
        ];
      }
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Update a group 
  */
  public function update(Request $request, $id)
  {
    $input = $this->groupData($request);
    $status = __('app.error');
    $data = [];
    if($request->name && empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif(!Group::whereId($id)->whereAppId($input['app_id'])->exists()) {
      $data = [
        'message' => 'group_id' . __('app.not_exist'),
      ];
    } elseif($request->name) {
      Group::whereId($id)->whereAppId($input['app_id'])->update(['name' => $input['name']]);
      activity('update')->withProperties(['app_id' => $input['app_id']])->log(__('app.group') . " ({$input['name']}) ". __('app.log_update')); // log
      $status = __('app.success');
      $data = [
        'id' => $id,
        'message' => __('app.group') .' '. __('app.log_update'),
      ];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Return inputed data
  */
  public function groupData($request)
  {
    $input = $request->all();
    $input['name'] = !empty($input['name']) ? trim($input['name']) : null;
    $input['user_id'] = $request->user('api')->id;
    $input['app_id'] = $request->user('api')->app_id;
    return $input;
  }

  /**
   * Delete a group 
  */
  public function delete(Request $request, $id)
  {
    $name = Group::whereAppId($request->user('api')->app_id)->whereId($id)->value('name');
    if(!empty($name)) {
      $destroy = Group::destroy($id);
      activity('delete')->withProperties(['app_id' => $request->user('api')->app_id])->log(__('app.group') . " ({$name}) ". __('app.log_delete'));

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
