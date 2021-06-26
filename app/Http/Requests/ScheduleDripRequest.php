<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleDripRequest extends FormRequest
{
  function authorize()
  {
    return true;
  }

  public function rules() {
    return [
      'name' => 'required|string|max:255',
      'drip_group_id' => 'required|integer',
      'list_ids' => 'required',
      'sending_server_id' => 'required',
    ];
  }
}
