<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SendingDomain;
use Auth;
use Helper;

class SendingDomainController extends Controller
{

  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('sending_domains'); // check user permission
    $page = 'setup_sending_domains'; // choose sidebar menu option
    return view('sending_domains.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getSendingDomains(Request $request)
  {
    $result = SendingDomain::select('id', 'domain', 'active', 'signing', 'verified_key', 'verified_spf', 'verified_tracking', 'created_at', 'verified_dmarc')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'id', 'domain', 'active', 'signing', 'verified_key', 'verified_spf', 'verified_dmarc', 'verified_tracking', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $sending_domains = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($sending_domains as $sending_domain) {
      $checkbox = "<input type=\"checkbox\" value=\"{$sending_domain->id}\">";
      $verified_key = $sending_domain->verified_key ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
      $verified_spf = $sending_domain->verified_spf ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
      $verified_dmarc = $sending_domain->verified_dmarc ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
      $verified_tracking = $sending_domain->verified_tracking ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu pull-right" role="menu">';
      $actions.= '<li><a href="'.route('sending_domain.show', ['id' => $sending_domain->id]).'"><i class="fa fa-eye"></i>'.__('app.view').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="domainVerifications(\''.$sending_domain->id.'\', \'all\')"><i class="fa fa-check"></i>'.__('app.verify_key_tracking').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="domainVerifications(\''.$sending_domain->id.'\', \'dkim\')"><i class="fa fa-check"></i>'.__('app.verify_dkim').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="domainVerifications(\''.$sending_domain->id.'\', \'spf\')"><i class="fa fa-check"></i>'.__('app.verify_spf').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="domainVerifications(\''.$sending_domain->id.'\', \'dmarc\')"><i class="fa fa-check"></i>'.__('app.verify').' DMARC</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="domainVerifications(\''.$sending_domain->id.'\', \'tracking\')"><i class="fa fa-check"></i>'.__('app.verify_tracking').'</a></li>';
      $actions .= '<li><a href="'.route('download.keys', ['id' => $sending_domain->id]).'"><i class="fa fa-download"></i>'.__('app.download_keys').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$sending_domain->id.'\', \''.route('sending_domain.destroy', ['id' => $sending_domain->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$sending_domain->id}",
        $checkbox,
        '<a href="'.route('sending_domain.show', ['id' => $sending_domain->id]).'">'.$sending_domain->id.'</a>',
        $sending_domain->domain,
        $sending_domain->active,
        $sending_domain->signing,
        "<span id='key-{$sending_domain->id}'>{$verified_key}</span>",
        "<span id='spf-{$sending_domain->id}'>{$verified_spf}</span>",
        "<span id='dmarc-{$sending_domain->id}'>{$verified_dmarc}</span>",
        "<span id='tracking-{$sending_domain->id}'>{$verified_tracking}<span>",
        Helper::datetimeDisplay($sending_domain->created_at),
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create()
  {
    Helper::checkPermissions('sending_domains'); // check user permission
    return view('sending_domains.create');
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
    $request->validate([
      'domain' => 'required|string|max:255|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|unique:sending_domains'
    ]);
    $input = $request->except('_token');
    $input['domain'] = $input['domain'];
    $input['protocol'] = $input['protocol'];
    $input['dkim'] = config('mc.dkim_selector');
    $input['dmarc'] = config('mc.dmarc_selector');
    $input['tracking'] = config('mc.tracking_selector');
    $input['user_id'] = Auth::user()->id;
    $input['app_id'] = Auth::user()->app_id;
    $keys = Helper::generateKeys();
    $input['public_key'] = $keys['public_key'];
    $input['private_key'] = $keys['private_key'];
    $sending_domain = SendingDomain::create($input);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_domain') . " ({$request->domain}) ". __('app.log_create')); // log
    return route('sending_domain.show', ['id' => $sending_domain->id]);
  }

  /**
   * Retrun sending domain view
  */
  public function show($id)
  { 
    Helper::checkPermissions('sending_domains'); // check user permission
    $sending_domain = SendingDomain::whereId($id)->app()->first();
    $page = 'setup_sending_domains'; // choose sidebar menu option
    $spf_record = Helper::getSPFRecordForDomain($sending_domain->domain);
    return view('sending_domains.view')->with(compact('page', 'sending_domain', 'spf_record'));
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(SendingDomain::whereIn('id', $ids)->pluck('domain')->toArray()));
      $destroy = SendingDomain::whereIn('id', $ids)->delete();
    } else {
      $names = SendingDomain::whereId($id)->value('domain');
      $destroy = SendingDomain::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_domain') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
    if(!empty($request->dkim)) {
      $request->validate([
        'dkim' => 'required',
        'dmarc' => 'required',
        'tracking' => 'required'
      ]);
      $data = [
        'dkim' => $request->dkim,
        'dmarc' => $request->dmarc,
        'tracking' => $request->tracking,
        'verified_key' => 0,
        'verified_dmarc' => 0,
        'verified_tracking' => 0
      ];
    } else {
      $data[$request->field] = $request->value;
    }
    $sending_domain = SendingDomain::findOrFail($id);
    $sending_domain->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_domain') . " ({$sending_domain->domain}) ". __('app.log_update')); // log
  }

  /**
   * Download sending domain public and private keys
  */
  public function downloadKeys($id)
  {
    Helper::checkPermissions('sending_domains'); // check user permission
    $sending_domain = SendingDomain::select('domain', 'public_key', 'private_key')->where('id', $id)->app()->first();

    $path_downloads = str_replace('[user-id]', Auth::user()->id, config('mc.path_downloads'));
    Helper::dirCreateOrExist($path_downloads); // create dir if not exist

    $public_key_file = $path_downloads.'public_key.txt';
    $private_key_file = $path_downloads.'private_key.txt';

    \File::put($public_key_file, $sending_domain->public_key);
    \File::put($private_key_file, $sending_domain->private_key);

    $zip_path = $path_downloads.$sending_domain->domain.'.zip';

    $zipper = new \Chumper\Zipper\Zipper;
    $zipper->make($zip_path)->add($public_key_file);
    $zipper->make($zip_path)->add($private_key_file);
    $zipper->close();

    \File::delete($public_key_file);
    \File::delete($private_key_file);


    activity('download')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_domain') . " ({$sending_domain->domain}) ". __('app.log_download_keys')); // log

    return response()->download($zip_path);
  }

  /**
   * Return after verify domain and tracking
  */
  public function domainVerifications($id, $type)
  {
    $sending_domain = SendingDomain::findOrFail($id);

    $key = $spf = $tracking = $dmarc = false;

    if($type == 'all' || $type == 'dkim') {
      // Verify DKIM
      $key = Helper::verifyDKIM($sending_domain);
    }

    if($type == 'all' || $type == 'tracking') {
      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify Tracking
      $tracking = Helper::verifyTracking($sending_domain);
    }

    if($type == 'all' || $type == 'spf') {
      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify SPF
      $spf = Helper::verifySPF($sending_domain);
    }

    if($type == 'all' || $type == 'dmarc') {
      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify SPF
      $dmarc = Helper::verifyDMARC($sending_domain);
    }

    $result = [
      'key' => $key,
      'spf' => $spf,
      'dmarc' => $dmarc,
      'tracking' => $tracking
    ];
    return json_encode($result);
  }
}
