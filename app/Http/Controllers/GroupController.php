<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\UniqueGroup;
use App\Models\Group;
use Auth;

class GroupController extends Controller
{
  /**
   * Retrun index view
  */
  public function create($type_id)
  {
    return view('groups.create')->with('type_id', $type_id);
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', new UniqueGroup],
    ]);
    $input = $request->all();
    $input['app_id'] = Auth::user()->app_id;
    $input['user_id'] = Auth::user()->id;
    Group::create($input);
    activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.group') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Create a group from other modules
  */
  public function createGroup($type_id, $name)
  {
    $group = Group::whereName($name)->whereTypeId($type_id)->first();
    if(empty($group)) {
      $input['name'] = $name;
      $input['type_id'] = $type_id;
      $input['app_id'] = Auth::user()->app_id;
      $input['user_id'] = Auth::user()->id;
      $group = Group::create($input);
    }
    return $group;
  }

  /**
   * Update data
  */
  public function update(Request $request)
  {
    Group::whereId($request->id)->update(['name' => $request->name]);
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.group') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Return groups
  */
  public function groups($type_id, $type_return)
  {
    return \App\Models\Group::groups($type_id, $type_return);
  }

  /**
   * Delete or Erease group
  */
  public function deleteGroup($model, Request $request)
  {
    $id = $request->id;
    $action = $request->action;
    $model = $request->model;

    if($model == 'list') {
      if($action == 'erase') {
        $destroy = \App\Models\Lists::whereGroupId($id)->delete();
      } elseif($action == 'move') {
        if(!empty($request->move_id))
          $destroy = \App\Models\Lists::whereId($request->move_id)->update(['group_id' => $request->group_id_new]);
        else
          $destroy = \App\Models\Lists::whereGroupId($id)->update(['group_id' => $request->group_id_new]);
      }
    } elseif($model == 'broadcast') {
      if($action == 'erase') {
        $destroy = \App\Models\Broadcast::whereGroupId($id)->delete();
      } elseif($action == 'move') {
        if(!empty($request->move_id))
          $destroy = \App\Models\Broadcast::whereId($request->move_id)->update(['group_id' => $request->group_id_new]);
        else
          $destroy = \App\Models\Broadcast::whereGroupId($id)->update(['group_id' => $request->group_id_new]);
      }
    } elseif($model == 'sending_server') {
      if($action == 'erase') {
        $destroy = \App\Models\SendingServer::whereGroupId($id)->delete();
      } elseif($action == 'move') {
        if(!empty($request->move_id))
          $destroy = \App\Models\SendingServer::whereId($request->move_id)->update(['group_id' => $request->group_id_new]);
        else
          $destroy = \App\Models\SendingServer::whereGroupId($id)->update(['group_id' => $request->group_id_new]);
      }
    } elseif($model == 'drip') {
      if($action == 'erase') {
        $destroy = \App\Models\Drip::whereGroupId($id)->delete();
      } elseif($action == 'move') {
        if(!empty($request->move_id))
          $destroy = \App\Models\Drip::whereId($request->move_id)->update(['group_id' => $request->group_id_new]);
        else
          $destroy = \App\Models\Drip::whereGroupId($id)->update(['group_id' => $request->group_id_new]);
      }
    } elseif($model == 'suppression') {
      if($action == 'erase') {
        $destroy = \App\Models\Suppression::whereGroupId($id)->delete();
      } elseif($action == 'move') {
        if(!empty($request->move_id))
          $destroy = \App\Models\Suppression::whereId($request->move_id)->update(['group_id' => $request->group_id_new]);
        else
          $destroy = \App\Models\Suppression::whereGroupId($id)->update(['group_id' => $request->group_id_new]);
      }
    }

    if(!empty($id)) {
      $group_name = Group::whereId($id)->value('name');
      activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.group') . " ({$group_name}) ". __('app.log_delete')); // log
      Group::destroy($id);
    }
    return $destroy;
  }
}
