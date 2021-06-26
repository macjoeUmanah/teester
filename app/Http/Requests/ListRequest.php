<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueList;

class ListRequest extends FormRequest
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
          'name' => ['required', 'string', new UniqueList],
          'sending_server_id' => 'required|integer',
          'notify_email' => 'required_if:notification,==,Enabled',
        ];
      break;
      case 'PUT':
        return [
          'group_id' => 'required|integer',
          'name' => ['required', 'string'],
          'sending_server_id' => 'required|integer',
          'notify_email' => 'required_if:notification,==,Enabled',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
