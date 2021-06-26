<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DripRequest extends FormRequest
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
          'name' => 'required|string|max:255|unique:drips,name,NULL,id,group_id,'.$this->group_id,
          'broadcast_id' => 'required|integer',
          'time' => 'required_if:send,==,After',
        ];
      break;
      case 'PUT':
        return [
          'name' => 'required|string|max:255',
          'broadcast_id' => 'required|integer',
          'time' => 'required_if:send,==,After',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
