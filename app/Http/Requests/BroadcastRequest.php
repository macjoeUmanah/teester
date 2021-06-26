<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BroadcastRequest extends FormRequest
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
          'group_id' => 'required|integer',
          'name' => 'required|string|max:255|unique:broadcasts,name,NULL,id,deleted_at,NULL',
          'email_subject' => 'required|string|max:255',
        ];
      break;
      case 'PUT':
        return [
          'group_id' => 'required|integer',
          'name' => 'required|string|max:255',
          'email_subject' => 'required|string|max:255',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
