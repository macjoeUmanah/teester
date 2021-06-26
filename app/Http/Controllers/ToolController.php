<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Auth;
use Helper;

class ToolController extends Controller
{
  /**
   * Retrun index view of logs
  */
  public function logsIndex()
  {
    Helper::checkPermissions('logs'); // check user permission
    $page = 'tools_logs'; // choose sidebar menu option
    return view('tools.logs')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getLogs(Request $request)
  {
    //$result = Activity::where('properties->app_id', Auth::user()->app_id)->with('causer');
    // For MariaDB
    $result = Activity::whereRaw("properties LIKE '%:".Auth::user()->app_id."%'")
      ->with('causer');
    
    $columns = ['description', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $logs = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($logs as $log) {
      $data['data'][] = [
        "DT_RowId" => "row_{$log->id}",
        "",
        $log->description ?? '---',
        $log->causer['name'] ?? '---',
        Helper::datetimeDisplay($log->created_at),
      ];
    }
    echo json_encode($data);
  }

  /**
   * Will take the backup of the application and the database
  */
  public function backup(Request $request)
  {
    Helper::checkPermissions('backup'); // check user permission
    $backup_db = !empty($request->backup_db) ? true : false;
    $backup_files = !empty($request->backup_files) ? true : false;

    // initiate job to take the backup
    \App\Jobs\Backup::dispatch(Auth::user()->id, Auth::user()->app_id, $backup_db, $backup_files);
    \Artisan::call('queue:work', ['--once' => true, '--timeout' => 120]); // execute queue

    activity('backup')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.tools_backup') . " (". Auth::user()->email .") ". __('app.log_backup')); // log
  }

  /**
   * Responsible to update the application
  */
  public function appUpdate()
  {
    Helper::checkPermissions('update'); // check user permission
    $page = 'tools_update'; // choose sidebar menu option
    
    try {
      // Fetch from own server
      $settings = \DB::table('settings')->whereId(config('mc.app_id'))->select('app_url', 'license_key')->first();
      $settings->current_version = Helper::getUrl($settings->app_url.config('mc.version_local_path'));
      $settings->available_version = Helper::getUrl(config('mc.version_live_path'));
    } catch (\Exception $e) {
      try {
        $settings = \DB::table('settings')->whereId(config('mc.app_id'))->select('app_url', 'license_key', 'current_version')->first();
        $settings->available_version = Helper::getUrl(config('mc.version_live_path'));
      } catch (\Exception $e) {}
    }
    if($settings->available_version > $settings->current_version) {
      $settings->msg = __('app.update_message_available');
      $settings->msg_text_color = 'text-orange';
    } else {
      $settings->msg = __('app.update_message_fine');
      $settings->msg_text_color = 'text-green';
    }
    return view('tools.update')->with(compact('page', 'settings'));
  }

  public function appUpdateProceed(Request $request)
  {
    $data = [
      'is_update' => true,
      'license_key' => $request->license_key,
      'server_ip' => $_SERVER['SERVER_ADDR']
    ];

    $result = json_decode(\Helper::verifyLicense($data), true);
    if($result['verify']) {

      // Copy updated files
      try {
        $file = config('mc.mailcarry_download_url').$request->license_key.'.zip';
        $dest_file = storage_path().DIRECTORY_SEPARATOR.'update.zip';
        copy($file, $dest_file);
        try {
          //chmod($dest_file, 0777);
        } catch (\Exception $e) {
          return $result['message'] = $e->getMessage();
        }
        
      } catch (\Exception $e) {
        return $result['message'] = $e->getMessage();
      }

      // Extract files
      try {
        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($dest_file)->extractTo(base_path());
        $zipper->close();
      } catch (\Exception $e) {
        return $result['message'] = $e->getMessage();
      }

      // Config, Cache, and View Clear
      \Artisan::call('config:cache');
      \Artisan::call('cache:clear');
      \Artisan::call('view:clear');

      // Migration
      try {
        \Artisan::call('migrate', ["--force" => true]);
      } catch (\Exception $e) {
        return $result['message'] = $e->getMessage();
      }

      // Update version file
      try {
        // Save version into db
        \DB::table('settings')->whereId(config('mc.app_id'))->update([
          'current_version' => '2.5.2'
        ]);
        $verion_file = config('mc.version_storage_path').'version';
        copy(config('mc.version_live_path'), $verion_file);
        try {
          //chmod($verion_file, 0777);
        } catch (\Exception $e) {
          return $result['message'] = $e->getMessage();
        }
      } catch (\Exception $e) {
        return $result['message'] = $e->getMessage();
      }

      // Delete donwloaded file after successful update
      try {
        unlink($dest_file);
      } catch (\Exception $e) {
        return $result['message'] = $e->getMessage();
      }

      // Check app updated completely
      $data = [
        'is_complete' => true,
        'license_key' => $request->license_key,
      ];

      return json_decode(\Helper::verifyLicense($data), true);
    } else {
      $data = [
        'verify' => false,
        'message' => 'Invalid license key',
      ];
      return json_encode($data);
    }
  }
}
