<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutoFollowupRequest extends FormRequest
{
  function authorize()
  {
    return true;
  }

  public function rules()
  {
    switch($this->method()) {
      case 'POST':
        return [
          'name' => 'required|string|max:255|unique:auto_followups',
          'segment_id' => 'required|integer',
          'broadcast_id' => 'required|integer',
          'sending_server_id' => 'required|integer',
        ];
      break;
      case 'PUT':
        return [
          'name' => 'required|string|max:255',
          'segment_id' => 'required|integer',
          'broadcast_id' => 'required|integer',
          'sending_server_id' => 'required|integer',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
