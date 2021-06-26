<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
          'name' => 'required|string|max:255',
         // 'email' => ['required', 'string', 'email', 'max:255', new UniqueUser],
          'email' => 'required|email|string|max:255|unique:users,email,NULL,id,deleted_at,NULL',
          'password' => 'required|confirmed|min:6',
          'role_id' => 'required|integer'
        ];
      break;
      case 'PUT':
        return [
          'name' => 'required|string|max:255',
          'password' => 'nullable|confirmed|min:6'
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
