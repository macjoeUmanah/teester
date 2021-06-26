<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
  function authorize()
  {
    return true;
  }

  public function rules()
  {
      $common = [
        'app_name' => 'required|string|max:255',
        //'app_url' => 'required|string|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i',
        'app_url' => 'required',
        'from_email' => 'required|email',
        'max_file_size' => 'required|integer|max:'.\Helper::getMaxFileSize(true),
      ];

      switch($this->type) {
        case 'smtp':
          $custom = [
            'host' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'port' => 'required|integer|min:0',
          ];
        break;
        case 'amazon_ses_api':
          $custom = [
            'access_key' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
          ];
        break;
        case 'mailgun_api':
          $custom = [
            'domain' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
          ];
        break;
        case 'sparkpost_api':
        case 'sendgrid_api':
        case 'mandrill_api':
          $custom = [
            'api_key' => 'required|string|max:255',
          ];
        break;
        default: 
          $custom = [];
        break;
      }
      

      return array_merge($common,$custom);
  }
}
