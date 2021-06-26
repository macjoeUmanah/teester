<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
          'list_id' => 'required|integer',
          'email' => 'required|string|email|max:255|unique:contacts,email,NULL,id,list_id,'.$this->list_id
        ];
      break;
      case 'PUT':
        return [
          'list_id' => 'required|integer',
          'email' => 'required|string|email|max:255'
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
