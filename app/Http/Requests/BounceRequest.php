<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BounceRequest extends FormRequest
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
          'email' => 'required|email|unique:bounces|string|max:255',
          'host' => 'required|string|max:255',
          'username' => 'required|string|max:255',
          'port' => 'required|integer|min:0',
        ];
      break;
      case 'PUT':
        return [
          'host' => 'required|string|max:255',
          'username' => 'required|string|max:255',
          'port' => 'required|integer|min:0',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
