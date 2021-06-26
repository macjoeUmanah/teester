<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailVerifier;
use Auth;
use Helper;
use Crypt;

class EmailVerifierController extends Controller
{
	/**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('email_verifiers'); // check user permission
    $page = 'list_email_verifiers'; // choose sidebar menu option
    return view('email_verifiers.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getEmailVerifiers(Request $request)
  {
    $result = EmailVerifier::select('id', 'name', 'type', 'attributes', 'active', 'total_verified', 'created_at')
      ->whereAppId(Auth::user()->app_id);
    
    $columns = ['id', 'id', 'name', 'type', 'total_verified', 'active', 'created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $email_verifiers = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($email_verifiers as $email_verifier) {
      $checkbox = "<input type=\"checkbox\" value=\"{$email_verifier->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions.= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('email_verifier.edit', ['id' => $email_verifier->id]).'\')"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$email_verifier->id.'\', \''.route('email_verifier.destroy', ['id' => $email_verifier->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul>
        </div>';
      $data['data'][] = [
        "DT_RowId" => "row_{$email_verifier->id}",
        $checkbox,
        $email_verifier->id,
        $email_verifier->name,
        $email_verifier->type,
        $email_verifier->total_verified,
        $email_verifier->active,
        Helper::datetimeDisplay($email_verifier->created_at),
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
    Helper::checkPermissions('email_verifiers'); // check user permission
    return view('email_verifiers.create');
  }

  /**
   * Save data
  */
  public function store(Request $request)
  {
  	$request->validate([
      'name' => 'required|string|unique:email_verifiers',
    ]);
    $data = $this->emailVerifierData($request);
    print_r($data);
    EmailVerifier::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.email_verifier') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('email_verifiers'); // check user permission
    $email_verifier = EmailVerifier::whereId($id)->app()->first();
    return view('email_verifiers.edit')->with(compact('email_verifier'));
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
  	$request->validate([
      'name' => 'required|string',
    ]);
    $data = $this->emailVerifierData($request);
    $email_verifier = EmailVerifier::findOrFail($id);
    $email_verifier->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.email_verifier') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function emailVerifierData($request)
  {
    $input = $request->except('_token');
    $input['attributes'] = $this->emailVerifierAttributes($input);
    $input['active'] = !empty($request->active) ? 'Yes' : 'No';
    $input['app_id'] = Auth::user()->app_id;
    $input['user_id'] = Auth::user()->id;
    return $input;
  }

  /**
   * Retrun JSON data for sending server
  */
  public function emailVerifierAttributes($data)
  {
  	switch($data['type']) {
      case 'kickbox':
      case 'neverbounce':
      case 'sendgrid':
      case 'mailgun':
      case 'bulkemailchecker':
        $attributes = [
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null
        ];
      break;
      case 'emailoversight':
        $attributes = [
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null,
          'list_id' => !empty($data['list_id']) ? $data['list_id'] : null,
        ];
      break;
      default: 
        $attributes = null;
      break;
    }
    return json_encode($attributes);
  }

  /**
   * Retrun email verifiers fields respectively
  */
  public function getEmailVerifiersFields($type, $action, $id=null)
  {
    if(!empty($id)) {
      $data = json_decode(EmailVerifier::whereId($id)->app()->value('attributes'));
    }
    return view('email_verifiers.attributes')->with(compact('type', 'action', 'data'));
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(EmailVerifier::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = EmailVerifier::whereIn('id', $ids)->delete();
    } else {
      $names = EmailVerifier::whereId($id)->value('name');
      $destroy = EmailVerifier::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.email_verifier') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Verify Email
  */
  public function verifyEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|email|string|max:255',
    ]);
    $data = $request->except('_token');
    $response = Helper::verifyEmail($data);
    if($response['increment']) {
      $verifier = \App\Models\EmailVerifier::whereId($request->id)->first();
      $verifier->increment('total_verified');
    } 
    
    return $response['success'] ? "<h4 class='text-success'>Valid ({$response['message']})</h4>" : "<h4 class='text-danger'>Invalid ({$response['message']})</h4>";
  }

  /**
   * Verify Email List
  */
  public function verifyEmailList(Request $request)
  {
    Helper::checkPermissions('email_verifiers'); // check user permission
    if($request->isMethod('post')) {
      $request->validate([
        'list_ids' => 'required',
        'type' => 'required'
      ]);
      \App\Jobs\ListVerify::dispatch($request->list_ids, $request->type, Auth::user()->id)
        ->delay(now()->addSeconds(10));
      \Artisan::call('queue:work', ['--once' => true]); // execute queue

      $list_names = json_encode(array_values(\App\Models\Lists::whereIn('id', $request->list_ids)->pluck('name')->toArray()));
      // Save activity log
      activity('verify')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.list') . " ({$list_names}) ". __('app.log_verify_list')); // log
    } else {
      $email_verifiers = EmailVerifier::whereActive('Yes')->app()->get();
      return view('email_verifiers.verify_list')->with(compact('email_verifiers'));
    }
  }
}
