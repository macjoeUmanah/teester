<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleCampaignStatLogBounce;
use App\Models\ScheduleCampaignStatLogSpam;
use Helper;
use Auth;

class EmailsBlacklistController extends Controller
{
  /**
   * Retrun global bounced
  */
  public function globalBounced()
  {
    Helper::checkPermissions('global_bounced'); // check user permission
    $page = 'blacklists_bounced'; // choose sidebar menu option
    return view('emails_blacklist.global_bounced')->with(compact('page'));
  }

  /**
   * Retrurn global bounces
  */
  public function getGlobalBounced(Request $request)
  {
    $result = ScheduleCampaignStatLogBounce::whereNotNull('email');

    $columns = ['id', 'email', 'type', 'code', 'detail', 'created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $bounced = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($bounced as $bounce) {
      $checkbox = "<input type=\"checkbox\" value=\"{$bounce->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$bounce->id.'\', \''.route('global.bounced.destroy', ['id' => $bounce->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$bounce->id}",
        $checkbox,
        $bounce->email,
        $bounce->type,
        $bounce->code,
        json_decode($bounce->detail)->short_detail ?? '---',
        Helper::datetimeDisplay($bounce->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }


  /**
   * Delete global bounced
  */
  public function destroyGlobalBounced($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $emails = json_encode(array_values(ScheduleCampaignStatLogBounce::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = ScheduleCampaignStatLogBounce::whereIn('id', $ids)->delete();
    } else {
      $emails = ScheduleCampaignStatLogBounce::whereId($id)->value('email');
      $destroy = ScheduleCampaignStatLogBounce::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.global_bounced') . " ({$emails}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Retrun global spam
  */
  public function globalSpam()
  {
    Helper::checkPermissions('global_spam'); // check user permission
    $page = 'blacklists_spam'; // choose sidebar menu option
    return view('emails_blacklist.global_spam')->with(compact('page'));
  }

  /**
   * Retrurn global spam
  */
  public function getGlobalSpam(Request $request)
  {
    $result = ScheduleCampaignStatLogSpam::whereNotNull('email');

    $columns = ['id', 'email', 'detail', 'created_at'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $bounced = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($bounced as $bounce) {
      $checkbox = "<input type=\"checkbox\" value=\"{$bounce->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a href="javascript:;" onclick="destroy(\''.$bounce->id.'\', \''.route('global.spam.destroy', ['id' => $bounce->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$bounce->id}",
        $checkbox,
        $bounce->email,
        json_decode($bounce->detail)->short_detail ?? '---',
        Helper::datetimeDisplay($bounce->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Delete global spam
  */
  public function destroyGlobalSpam($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $emails = json_encode(array_values(ScheduleCampaignStatLogSpam::whereIn('id', $ids)->pluck('email')->toArray()));
      $destroy = ScheduleCampaignStatLogSpam::whereIn('id', $ids)->delete();
    } else {
      $emails = ScheduleCampaignStatLogSpam::whereId($id)->value('email');
      $destroy = ScheduleCampaignStatLogSpam::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.global_bounced') . " ({$emails}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Import Bounced
  */
  public function importBounced(Request $request)
  {
    if($request->isMethod('post')) {
      if(!empty($request->fieldMapping)) {
        $path_import_blacklist = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_blacklist'));
        $file = $path_import_blacklist.'bounces-header.csv';

        $file_header = Helper::getCsvFileHeader($file);

        $drop_down = '<select name="bounce_fields[]" class="form-control">';
        $drop_down .= "<option value=''>None</option>";
        foreach($file_header as $key  => $header) {
          $drop_down .= "<option value='{$key}'>{$header}</option>";
        }
        $drop_down .= '</select>';

        $string = '';
        $string .= "<div class='form-group'>
              <label class='col-md-2 control-label'>Email</label>
              <div class='col-md-6'>{$drop_down}</div>
            </div>";
        $string .= "<div class='form-group'>
              <label class='col-md-2 control-label'>Type</label>
              <div class='col-md-6'>{$drop_down}</div>
            </div>";
        $string .= "<div class='form-group'>
              <label class='col-md-2 control-label'>Code</label>
              <div class='col-md-6'>{$drop_down}</div>
            </div>";
        $string .= "<div class='form-group'>
              <label class='col-md-2 control-label'>Detail</label>
              <div class='col-md-6'>{$drop_down}</div>
            </div>";
        return $string;
      } elseif($request->do_import) {
        $attributes = $request->except('_token', 'file', 'do_import');
        try{
          $path_import_blacklist = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_blacklist'));
          $file_name = md5(uniqid()).'.csv';
          $file_path = $path_import_blacklist.$file_name;

          $file = $request->file('file');
          $file->move($path_import_blacklist, $file_name); // save original file to import

          $reader = \League\Csv\Reader::createFromPath($file_path, 'r');
          $records = $reader->getRecords();
          foreach ($records as $offset => $record) {
            $email = !empty($record[$request->bounce_fields[0]]) ? $record[$request->bounce_fields[0]] : null;
            if (filter_var($record[$request->bounce_fields[0]], FILTER_VALIDATE_EMAIL) &&
            !ScheduleCampaignStatLogBounce::whereEmail($email)->exists() ) {
              $code = !empty($record[$request->bounce_fields[2]]) ? $record[$request->bounce_fields[2]] : null;
              $type = !empty($record[$request->bounce_fields[1]]) ? $record[$request->bounce_fields[1]] : 'Soft';
              $detail = !empty($record[$request->bounce_fields[3]]) ? $record[$request->bounce_fields[3]] : null;
              $bounce_data = [
                'schedule_campaign_stat_log_id' => 0,
                'section' => 'Campaign',
                'email'  => $email,
                'code'   => $code,
                'type'   => $type,
                'detail' => json_encode(['short_detail' => $detail, 'full_detail' => $detail ] ),
                'created_at' => \Carbon\Carbon::now(),
              ];
              ScheduleCampaignStatLogBounce::create($bounce_data);
            }
          }

          unlink($path_import_blacklist.'bounces-header.csv'); // delete header file
          unlink($path_import_blacklist.$file_name); // delete header file
        } catch(\Exception $e) {
          //echo $e->getMessage();
        }
      } else {
        $request->validate([
          'file' => 'required|mimes:csv,txt|max:'.Helper::getMaxFileSizeMB()
        ]);
        $file = $request->file('file');
        //echo $file->originalName();
        $header = Helper::getCsvFileHeader($file);
        $path_import_blacklist = str_replace('[user-id]', Auth::user()->id, config('mc.path_import_blacklist'));
        Helper::dirCreateOrExist($path_import_blacklist); // create dir if not exist

        $file = $path_import_blacklist.'bounces-header.csv';

        $writer = \League\Csv\Writer::createFromPath($file, 'w'); // create a .csv file to write data
        $writer->insertOne($header); // write file header
      }
    } else {
      return view('emails_blacklist.import_bounced');
    }
  }

  /**
   * Export Bounced
  */
  public function exportBounced()
  {
    \App\Jobs\BounceExport::dispatch(Auth::user()->app_id, Auth::user()->id)
      ->delay(now()->addSeconds(10));
    \Artisan::call('queue:work', ['--once' => true]); // execute queue

    // save activity log
    activity('export')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.global_bounced') .' ' . __('app.log_export')); // log
  }

  /**
   * Display blacklisted IPs
  */
  public function blacklistedIPs()
  {
    Helper::checkPermissions('blacklisted_ips'); // check user permission
    $page = 'blacklists_ips'; // choose sidebar menu option
    return view('emails_blacklist.blacklisted_ips')->with(compact('page'));
  }

  /**
   * Retrurn blacklisted ips
  */
  public function getblacklistedIPs(Request $request)
  {
    $result = \DB::table('blacklisteds')
      ->where('ip_domain', 'ip')
      ->where('app_id', Auth::user()->app_id);

    $columns = ['name', 'counts'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $blacklisteds = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($blacklisteds as $blacklisted) {
      $detail = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('blacklisted.detail', ['id' => $blacklisted->id]).'\')">'.__('app.detail').'</a>';
      $data['data'][] = [
        $blacklisted->name,
        $blacklisted->counts,
        $detail
      ];
    }
    echo json_encode($data);
  }

  /**
   * Display blacklisted Domains
  */
  public function blacklistedDomains()
  {
    Helper::checkPermissions('blacklisted_domains'); // check user permission
    $page = 'blacklists_domains'; // choose sidebar menu option
    return view('emails_blacklist.blacklisted_domains')->with(compact('page'));
  }

  /**
   * Retrurn blacklisted ips
  */
  public function getblacklistedDomains(Request $request)
  {
    $result = \DB::table('blacklisteds')
      ->where('ip_domain', 'domain')
      ->where('app_id', Auth::user()->app_id);

    $columns = ['name', 'counts'];
    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $blacklisteds = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($blacklisteds as $blacklisted) {
      $detail = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('blacklisted.detail', ['id' => $blacklisted->id]).'\')">'.__('app.detail').'</a>';
      $data['data'][] = [
        $blacklisted->name,
        $blacklisted->counts,
        $detail
      ];
    }
    echo json_encode($data);
  }

  public function blacklistedDetail($id)
  {
    $blacklisted = \DB::table('blacklisteds')->whereId($id)->whereAppId(Auth::user()->app_id)->first();
    return view('emails_blacklist.blacklisted_detail')->with('blacklisted', $blacklisted);
  }
}
