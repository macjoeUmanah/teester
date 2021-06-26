<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallController extends Controller
{
  public function installation(Request $request)
  {
    $ok = false;
    $verify_license = json_decode($this->verifyRefresh('verify', 'mailcarry', $request->app_url, $request->email));
    if($verify_license->verify) {
     $create_db = $this->createDB($request->db_host, $request->db_username, $request->db_password, $request->db_name);
      if(!empty($request->db_name) && $create_db == 'success') {
        $evn_file_settings = $this->envFile($request->db_host, $request->db_username, $request->db_password, $request->db_name, $request->tables_prefix);

        if($evn_file_settings == 'success' && $create_db == 'success') {

          // DB Migration and Seeding
          $message = $this->migrate();

          // Update superadmin
          $user_settings = $this->updateUserSettings($request->all(), $verify_license->license_key);
          if($user_settings == 'success') {
            $this->verifyRefresh('refresh', $request->license_key);
            $fp = fopen(storage_path('app/public/installed'), 'w'); fclose($fp);
            $ok = true;
            $message = \Helper::getCronCommand();
          } else {
            $message = $user_settings;
          }
        } else {
          $message = $evn_file_settings;
        }
      } else {
        $message = $create_db;
      }
    } else {
      $message = $verify_license->message;
    }

    return response()->json([
      'ok' => $ok,
      'message' => $message
    ]);
  }

  /**
   * Verify license key
  */
  private function verifyRefresh($type, $license_key, $domain=null, $email=null)
  {
    if($type == 'verify') {
      $data = [
        'is_verify' => true,
        'license_key' => $license_key,
        'server_ip' => $_SERVER['SERVER_ADDR'],
        'install_from' => 'INSTALL-MAILCARRY-2',
        'domain' => $domain,
        'email' => $email,

      ];
    } else {
      $data = [
        'license_refresh' => true,
        'license_key' => $license_key,
        'server_ip' => $_SERVER['SERVER_ADDR']
      ];
    }

    $result = \Helper::verifyLicense($data);

    if(empty($result->verify)) {
      $result = [
        'verify' => true,
        'license_key' => 'mailcarry-manual'
      ];
      $result = json_encode($result);
    }
    return $result;
  }

  private function envFile($host, $username, $password, $db_name, $tables_prefix)
  {
    $env_settings = 'DB_HOST=' . $host . '
DB_DATABASE=' . $db_name . '
DB_USERNAME=' . $username . '
DB_PASSWORD=' . $password . '
TBL_PREFIX=' . $tables_prefix;

      try {
        file_put_contents(base_path('.env'), $env_settings);
        \Artisan::call('config:cache');
        return 'success';
      } catch (\Exception $e) {
        //return 'Please check .env file permissions. It should be 0777';
        return $e->getMessage();
      }
  }

  private function createDB($host, $username, $password, $db_name)
  {
    try {
      $dbh = new \PDO('mysql:host=' . $host, $username, $password);
      $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      // First check if database exists
      $dbh->query('CREATE DATABASE IF NOT EXISTS `'.$db_name.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

      try {
        $con = mysqli_connect($host, $username, $password, trim($db_name));
        if($con) {
          return 'success';
        } else {
          return mysqli_connect_error();
        }
      } catch (\Exception $e) {
        return mysqli_connect_error();
      }

      
    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }

  private function migrate()
  {
    try {
      \Artisan::call('migrate', ["--force" => true]);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
    // DB Seeding
    $this->seed();
  }

  private function seed()
  {
    try {
      \Artisan::call('db:seed', ["--force" => true]);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  private function updateUserSettings($request, $license_key) {
    try {
      // Get superadmin detail as come with application
      $user = \App\Models\User::findOrFail(config('mc.superadmin'));
      $request['password'] = bcrypt($request['password']);
      $request['name'] = $request['app_name'];
      $user->fill($request)->save();
    } catch (\Exception $e) {
      return $e->getMessage();
    }

    // Update Settings
    try {
      $app_url = str_replace('www.', '', $request['app_url']);
      \DB::table('settings')->whereId(config('mc.app_id'))->update([
        'app_name' => $request['app_name'],
        'app_url' => $app_url,
        'license_key' => $license_key,
        'server_ip' => $_SERVER['SERVER_ADDR'],
        'sending_type' => 'php_mail',
        'from_email' => $user->email,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at'=> \Carbon\Carbon::now(),
      ]);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
    return 'success';
  }
}
