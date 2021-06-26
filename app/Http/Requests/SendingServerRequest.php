<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendingServerRequest extends FormRequest
{
  function authorize()
  {
    return true;
  }

  public function rules()
  {
      $common = [
        'group_id' => 'required|integer',
        'name' => 'required|string|max:255',
        'from_name' => 'required|string|max:255',
        'from_email_part1' => 'required|string|max:255',
        'from_email_part2' => 'required',
        'reply_email' => 'required|email|string|max:255',
        //'tracking_domain' => 'required',
        //'bounce_id' => 'required_if:pmta_id,==,NULL',
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
        case 'elastic_email_api':
          $custom = [
            'account_id' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
          ];
        break;
        case 'mailjet_api':
          $custom = [
            'api_key' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
          ];
        break;
        case 'sparkpost_api':
        case 'mandrill_api':
        case 'sendgrid_api':
        case 'sendinblue_api':
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

  public function messages()
  {
      return [
          'bounce_id.required_if' => 'The bounce email is required',
      ];
  }
}
