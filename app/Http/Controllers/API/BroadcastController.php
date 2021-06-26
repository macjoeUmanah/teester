<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use Helper;

class BroadcastController extends Controller
{
  /**
   * Retrun a broadcast detail
  */
  public function get(Request $request, $id)
  {
    $broadcast = Broadcast::whereId($id)->whereAppId($request->user('api')->app_id)->first();

    if(!empty($broadcast)) {
      $data = [
        'id' => $broadcast->id,
        'name' => $broadcast->name,
        'group_id' => $broadcast->group->id,
        'group_name' => $broadcast->group->name,
        'email_subject' => $broadcast->email_subject,
        'html' => $broadcast->content_html,
        'text' => $broadcast->content_text,
        'created_at' => \Helper::datetimeDisplay($broadcast->created_at)
      ];
      $status = __('app.success');
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Retrun broadcasts
  */
  public function getBroadcasts(Request $request)
  {
    $result = Broadcast::whereAppId($request->user('api')->app_id)->with('group');

    if(!empty($request->group_id))
      $result->whereListId($request->group_id);

    if(!empty($request->start_from))
      $result->offset($request->start_from);

    $data = $result->limit(500)->get();
    return Helper::apiReturn(__('app.success'), $data);
  }

  /**
   * Add a broadcast
  */
  public function add(Request $request)
  {
    $input = $this->broadcastData($request);

    $status = __('app.error');
    if(empty($input['name'])) {
      $data = [
        'message' => 'name' . __('app.is_required'),
      ];
    } elseif(empty($input['group_id'])) {
      $data = [
        'message' => 'group_id' . __('app.is_required'),
      ];
    } elseif(empty($input['email_subject'])) {
      $data = [
        'message' => 'email_subject' . __('app.is_required'),
      ];
    } else {
      if(!\App\Models\Group::whereId($input['group_id'])->whereAppId($input['app_id'])->whereTypeId(config('mc.groups.broadcasts'))->exists()) {
        $data = [
          'message' => 'group_id' . __('app.not_exist'),
        ];
      } else {
        $broadcast = Broadcast::whereAppId($input['app_id'])->whereName($input['name'])->select('id')->first();
        if(!empty($broadcast->id)) {
          $data = [
            'id' => $broadcast->id,
            'message' => __('app.broadcast') . __('app.already_exist'),
          ];
        } else {
          $broadcast = Broadcast::create($input);
          activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.broadcast') . " ({$input['name']}) ". __('app.log_create')); // log

          $status = __('app.success');
          $data = [
            'id' => $broadcast->id,
            'name' => $input['name']
          ];
        }
      }
    }
    return Helper::apiReturn($status, $data);
  }

  /**
   * Update a broadcast 
  */
  public function update(Request $request, $id)
  {
    $input = $this->broadcastData($request);
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
    } elseif($request->email_subject && empty($input['email_subject'])) {
      $data = [
        'message' => 'email_subject' . __('app.is_required'),
      ];
    } else {
      if($request->email_subject && empty($input['email_subject']) && !\App\Models\Group::whereId($input['group_id'])->whereAppId($input['app_id'])->whereTypeId(config('mc.groups.broadcasts'))->exists()) {
        $data = [
          'message' => 'group_id' . __('app.not_exist'),
        ];
      } else {
        try {
          $broadcast = Broadcast::findOrFail($id);
          $input['name'] = empty($input['name']) ? $broadcast->name : $input['name'];
          $input['group_id'] = empty($input['group_id']) ? $broadcast->group_id : $input['group_id'];
          $input['email_subject'] = empty($input['email_subject']) ? $broadcast->email_subject : $input['email_subject'];
          $input['content_html'] = empty($input['content_html']) ? $broadcast->content_html : $input['content_html'];
          $input['content_text'] = empty($input['content_text']) ? $broadcast->content_text : $input['content_text'];
          $broadcast->fill($input)->save();
          activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.broadcast') . " ({$input['name']}) ". __('app.log_update')); // log

          $status = __('app.success');
          $data = [
            'id' => $broadcast->id,
            'name' => $input['name']
          ];
        } catch (\Exception $e) {
          $data = [
            'message' => $e->getMessage(),
          ];
        }
      }
    }
    return Helper::apiReturn($status, $data);
  }

  /**
   * Return inputed data
  */
  public function broadcastData($request)
  {
    $input = $request->all();
    $input['group_id'] = !empty($input['group_id']) ? trim($input['group_id']) : null;
    $input['name'] = !empty($input['name']) ? trim($input['name']) : null;
    $input['email_subject'] = !empty($input['email_subject']) ? $input['email_subject'] : null;
    $input['content_html'] = !empty($input['html']) ? $input['html'] : null;
    $input['content_text'] = !empty($input['text']) ? $input['text'] : null;
    $input['user_id'] = $request->user('api')->id;
    $input['app_id'] = $request->user('api')->app_id;
    return $input;
  }

  /**
   * Delete a broadcast
  */
  public function delete(Request $request, $id)
  {
    $name = Broadcast::whereId($id)->whereAppId($request->user('api')->app_id)->value('name');
    if(!empty($name)) {
      $destroy = Broadcast::destroy($id);
      activity('delete')->withProperties(['app_id' => $request->user('api')->app_id])->log(__('app.broadcast') . " ({$name}) ". __('app.log_delete'));

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
