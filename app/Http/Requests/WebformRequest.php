<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebformRequest extends FormRequest
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
          'name' => 'required|unique:webforms|string|max:255',
          'list_id' => 'required|integer',
          'thankyou_page_custom_url' => 'required_if:thankyou_page_option,==,custom',
          'confirmation_page_custom_url' => 'required_if:confirmation_page_option,==,custom|url',
        ];
      break;
      case 'PUT':
        return [
          'name' => 'required|string|max:255',
          'list_id' => 'required|integer',
          'thankyou_page_custom_url' => 'required_if:thankyou_page_option,==,custom',
          'confirmation_page_custom_url' => 'required_if:confirmation_page_option,==,custom|url',
        ];
      break;
      default: 
        return [];
      break;
    }
  }
}
