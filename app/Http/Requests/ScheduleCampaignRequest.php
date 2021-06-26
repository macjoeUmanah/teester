<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleCampaignRequest extends FormRequest
{
  function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'name' => 'required|string|max:255',
      'broadcast_id' => 'required|integer',
      'list_ids' => 'required',
      'sending_server_ids' => 'required',
      'send_date' => 'required_if:send,==,later',
      'limit' => 'required_if:speed,==,limited',
    ];
  }
}
