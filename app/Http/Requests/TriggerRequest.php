<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TriggerRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    switch($this->method()) {
      case 'POST':
        return [
          //'name' => 'required|string|max:255|unique:triggers,name,NULL,id,user_id,'.\Auth::user()->id,
          'name' => 'required',
          'send_date_execute' => 'required_if:execute,==,later',
          'based_on' => 'required',
          'list_ids' => 'required_if:based_on,==,list',
          'segment_id' => 'required_if:based_on,==,segment',
          'send_date' => 'required_if:based_on,==,date',
          'send_time' => 'required_if:based_on,==,date',
          'broadcast_id' => 'required_if:action,==,send_campaign',
          'drip_group_id' => 'required_if:action,==,start_drip',
          'sending_server_ids' => 'required',
          'trigger_start_limit' => 'required_if:trigger_start,==,after_event',
          'limit' => 'required_if:speed,==,limited',
        ];
      break;
      case 'PUT':
        return [
          'name' => 'required',
          'list_ids' => 'required_if:based_on,==,list',
          'segment_id' => 'required_if:based_on,==,segment',
          'send_date' => 'required_if:based_on,==,date',
          'send_time' => 'required_if:based_on,==,date',
          'broadcast_id' => 'required_if:action,==,send_campaign',
          'drip_group_id' => 'required_if:action,==,start_drip',
          'sending_server_ids' => 'required',
          'trigger_start_limit' => 'required_if:trigger_start,==,after_event',
          'limit' => 'required_if:speed,==,limited',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
