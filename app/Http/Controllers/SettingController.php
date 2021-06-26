<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;
use Illuminate\Support\Str;
use DB;
use Auth;
use Helper;

class SettingController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('settings_application'); // check user permission
    $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
    $page = 'settings_application'; // choose sidebar menu option
    return view('settings.index')->with(compact('page', 'settings'));
  }

  /**
   * Update data
  */
  public function update(SettingsRequest $request)
  {
    Helper::checkPermissions('settings_application'); // check user permission
    $input = $request->except('_token');
    $app_url = str_replace('www.', '', $input['app_url']);

    $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
    // Set manually installed license key
    if($settings->license_key == 'mailcarry-manual') {
      $data = [
        'is_verify' => true,
        'license_key' => 'mailcarry',
        'server_ip' => $_SERVER['SERVER_ADDR'],
        'install_from' => 'INSTALL-MAILCARRY-2',
        'domain' => $app_url,
        'email' => Auth::user()->email,
      ];
      try {
        $result = \Helper::verifyLicense($data);
        \DB::table('settings')->whereId(config('mc.app_id'))->update([
          'license_key' => json_decode($result)->license_key,
          'server_ip' => $_SERVER['SERVER_ADDR'],
        ]);
      } catch(\Exception $e) {
        // nothing
      }
    }

    $input['sending_attributes'] = app('App\Http\Controllers\SendingServerController')->sendingServerAttributes($input);

    $general_settings = json_encode([
      'max_file_size' => $input['max_file_size'],
      'bounced_recipients' => $input['bounced_recipients'],
      'spam_recipients' => $input['spam_recipients'],
      'suppressed_recipients' => $input['suppressed_recipients']
    ]);
    DB::table('settings')->whereId(config('mc.app_id'))->update([
      'app_name' => $input['app_name'],
      'app_url' => $app_url,
      'tracking' => $input['tracking'],
      'from_email' => $input['from_email'],
      'sending_type' => $input['type'],
      'sending_attributes' => $input['sending_attributes'],
      'attributes->login_backgroud_color' => $input['login_backgroud_color'],
      'attributes->top_left_html' => \Helper::XSSReplaceTags($input['top_left_html']),
      'attributes->login_html' => \Helper::XSSReplaceTags($input['login_html']),
      'general_settings' => $general_settings,
    ]);

    if($request->hasFile('file')){ 
      $request->validate([
        'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB
      ]);
      $file = $request->file('file');
      $file_ext = $file->getClientOriginalExtension();
      $file_name = 'login_image.'.$file_ext;
      $file->move(config('mc.path_login_img'), $file_name);
      DB::table('settings')->whereId(config('mc.app_id'))->update([
        'attributes->login_image' => "{$app_url}/storage/app/public/{$file_name}",
      ]);
    }
  }

  /**
   * Retrun API view and save data
  */
  public function api(Request $request)
  {
    Helper::checkPermissions('settings_api'); // check user permission
    $user = \App\Models\User::whereAppId(Auth::user()->app_id)->first();
    if($request->method() == 'PUT') {
      $user->fill([
        'api_token' => Str::random(60)
      ])->save();
    }
    $page = 'settings_api'; // choose sidebar menu option
    return view('settings.api')->with(compact('page', 'user'));
  }

  /**
   * Retrun API view and save data
  */
  public function apiStatus(Request $request)
  {
    $user = \App\Models\User::whereAppId(Auth::user()->app_id)->first();
    if($request->method() == 'PUT') {
      $user->fill([
        'api' => $request->value
      ])->save();
    }
  }

  /**
   * Custom Mail Headers for campaign
  */
  public function mailHeaders(Request $request)
  {
    Helper::checkPermissions('settings_mail_headers'); // check user permission
    $page = 'settings_mail_headers'; // choose sidebar menu option
    if($request->post()) {
      $headers = [];
      foreach($request->mail_headers as $header) {
        if(!empty($header['key'])) {
          $headers[$header['key']] = $header['value'];
        }
      }

      // Save headers
      $table = Auth::user()->app_id == config('mc.app_id') ? 'settings' : 'client_settings';
      $settings = DB::table($table);
      $settings = $table == 'settings' 
      ? $settings->whereId(Auth::user()->app_id)
      : $settings->whereAppId(Auth::user()->app_id);

      $settings->update([
        'mail_headers' => json_encode($headers)
      ]);
    } else {
      $table = Auth::user()->app_id == config('mc.app_id') ? 'settings' : 'client_settings';
      $settings =  DB::table($table)->select('mail_headers');
      $settings = $table == 'settings' 
      ? $settings->whereId(Auth::user()->app_id)
      : $settings->whereAppId(Auth::user()->app_id);

      $mail_headers = json_decode($settings->value('mail_headers'), true);
      return view('settings.mail_headers')->with(compact('page', 'mail_headers'));
    }
    
  }

  /**
   * App verification
   * WARNING!!! Avoid to make any changes in it.
  */
  public function licenseVerification(Request $request)
  {
    $data = [
      'license_refresh' => true,
      'license_key' => $request->license_key,
      'server_ip' => $_SERVER['SERVER_ADDR']
    ];

    $result = json_decode(\Helper::verifyLicense($data), true);

    if($result['verify']) {
      DB::table('settings')->whereId(config('mc.app_id'))->update(['license_key' => $request->license_key]);
      $result['message'] = 'Successfully updated!';
    }

    return response()->json([
      'verify' => $result['verify'],
      'message' => $result['message']
    ]);

  }

}
