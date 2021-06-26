<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendingServerRequest;
use App\Models\SendingServer;
use Auth;
use Helper;
use Crypt;

class SendingServerController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('sending_servers'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.sending_server'));
    $page = 'setup_sending_servers'; // choose sidebar menu option
    return view('sending_servers.index')->with(compact('page', 'groups'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getSendingServers(Request $request)
  {
    $result = SendingServer::join('groups', 'groups.id', '=', 'sending_servers.group_id')
      ->select('sending_servers.id', 'sending_servers.name as name', 'sending_servers.type', 'sending_servers.total_sent', 'sending_servers.status', 'sending_servers.speed_attributes', 'sending_servers.notification', 'sending_servers.created_at', 'groups.id as group_id', 'groups.name as group_name')
      ->where('sending_servers.app_id', Auth::user()->app_id);
    
    $columns = ['sending_servers.id', 'sending_servers.id', 'sending_servers.name', 'groups.name', 'sending_servers.type', 'sending_servers.total_sent', 'sending_servers.speed_attributes', 'sending_servers.status', 'sending_servers.created_at'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $sending_servers = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($sending_servers as $sending_server) {
      $checkbox = "<input type=\"checkbox\" value=\"{$sending_server->id}\">";
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a href="'.route('sending_server.edit', ['id' => $sending_server->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      $actions .= '<li><a href="'.route('sending_server.copy', ['id' => $sending_server->id]).'"><i class="fa fa-copy"></i>'.__('app.make_a_copy').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="move(\''.$sending_server->id.'\', \''.htmlentities($sending_server->name).'\')"><i class="fa fa-arrows"></i>'.__('app.move').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="viewModal(\'modal\', \''.route('send.email', ['broadcast_id' => 0, 'sending_server_id' => $sending_server->id, 'template_id' => 0]).'\')"><i class="fa fa-send-o"></i>'.__('app.send_test_email').'</a></li>';
      $actions .= '<li><a href="javascript:;" onclick="resetSentCounter(\''.$sending_server->id.'\')"><i class="fa fa-refresh "></i>'.__('app.reset_sent_counter').'</a></li>';
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$sending_server->id.'\', \''.route('sending_server.destroy', ['id' => $sending_server->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';

      $group_name = "<span id='{$sending_server->group_id}'>$sending_server->group_name<span>";

      $name = $sending_server->status == 'System Inactive' || $sending_server->status == 'System Paused' ?  '<a href="javascript:;" onclick="swal(\''.$sending_server->notification.'\')"><i class="fa fa-info-circle text-red"></i></a> '.$sending_server->name : $sending_server->name;
      $data['data'][] = [
        "DT_RowId" => "row_{$sending_server->id}",
        $checkbox,
        $sending_server->id,
        $name,
        $group_name,
        Helper::sendingServers($sending_server->type),
        json_decode($sending_server->speed_attributes)->speed,
        $sending_server->total_sent,
        $sending_server->status,
        Helper::datetimeDisplay($sending_server->created_at),
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
    if(!Helper::allowedLimit(Auth::user()->app_id, 'no_of_sending_servers', 'sending_servers')) {
      return view('errors.not_allowed')->with('module', __('app.setup_sending_servers'));
    }
    Helper::checkPermissions('sending_servers'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.sending_server'));
    $sending_domains = \App\Models\SendingDomain::getSendingDomains();
    $bounces = \App\Models\Bounce::getBounces();
    $page = 'setup_sending_servers'; // choose sidebar menu option
    return view('sending_servers.create')->with(compact('page', 'groups', 'sending_domains', 'bounces'));
  }

  /**
   * Save data
  */
  public function store(SendingServerRequest $request)
  {
    if(!Helper::allowedLimit(Auth::user()->app_id, 'no_of_sending_servers', 'sending_servers')) {
      return false;
    }
    $data = $this->sendingServerData($request);
    SendingServer::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_server') . " ({$request->name}) ". __('app.log_create')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('sending_servers'); // check user permission
    $groups = \App\Models\Group::groups(config('mc.groups.sending_server'));
    $sending_server = SendingServer::whereId($id)->app()->first();
    $sending_domains = \App\Models\SendingDomain::getSendingDomains();
    $bounces = \App\Models\Bounce::getBounces();
    $page = 'setup_sending_servers'; // choose sidebar menu option
    return view('sending_servers.edit')->with(compact('page', 'groups', 'sending_domains', 'bounces', 'sending_server'));
  }

  /**
   * Update data
  */
  public function update(SendingServerRequest $request, $id)
  {
    $data = $this->sendingServerData($request);
    $sending_server = SendingServer::findOrFail($id);
    // No need to update System Inactive / System Paused to Inactive; otherwise it will not active again automatically
    $data['status'] = ($sending_server->status == 'System Inactive' || $sending_server->status == 'System Paused') 
      && $data['status'] == 'Inactive' ? $sending_server->status : $data['status'];
    $sending_server->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_server') . " ({$request->name}) ". __('app.log_update')); // log
  }

  /**
   * Retrun data for store or update
  */
  public function sendingServerData($request)
  {
    $input = $request->except('_token');
    $input['bounce_id'] = !empty($input['bounce_id']) && $input['bounce_id'] != 0 ? $input['bounce_id'] : null;
    $input['tracking_domain'] = !empty($input['tracking_domain']) ? $input['tracking_domain'] : null;
    $input['status'] = !empty($request->active) ? 'Active' : 'Inactive';
    $input['sending_attributes'] = $this->sendingServerAttributes($input);
    $input['from_email'] = $input['from_email_part1'] . '@' . $input['from_email_part2'];
    if($input['speed'] == 'Unlimited') {
      $input['limit'] = $input['duration'] = null;
    }
    $input['speed_attributes'] = json_encode(['speed'=>$input['speed'], 'limit'=>$input['limit'], 'duration'=>$input['duration']]);
    $input['app_id'] =  Auth::user()->app_id;
    $input['user_id'] = Auth::user()->id;
    return $input;
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    if(!empty($request->action)) {
      $ids = array_values($request->ids);
      $names = json_encode(array_values(SendingServer::whereIn('id', $ids)->pluck('name')->toArray()));
      $destroy = SendingServer::whereIn('id', $ids)->delete();
    } else {
      $names = SendingServer::whereId($id)->value('name');
      $destroy = SendingServer::destroy($id);
    }
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_server') . " ({$names}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * Retrun index after copy sending server
  */
  public function copy($id)
  {
    Helper::checkPermissions('sending_servers'); // check user permission
    $sending_server = SendingServer::whereId($id)->app()->first();
    $sending_server->name = $sending_server->name .' - copy ';
    $copied_sending_server = $sending_server->replicate();
    $copied_sending_server->save();
    activity('copy')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.sending_server') . " ({$sending_server->name}) ". __('app.log_copy')); // log
    session()->flash('msg', trans('app.msg_successfully_copied'));
    return redirect(route('sending_servers.index'));
  }

  /**
   * Retrun JSON data for sending server
  */
  public function sendingServerAttributes($data)
  {
    switch($data['type']) {
      case 'smtp':
        if(!empty($data['password'])) {
          $data['password'] = $data['password'] == '#########' ? $data['smtpid'] : Crypt::encrypt($data['password']);
        }

        $attributes = [
          'host' => $data['host'],
          'username' => $data['username'],
          'password' => !empty($data['password']) ? $data['password'] : null,
          'port' => $data['port'],
          'encryption' => $data['encryption'],
          'body_encoding' => $data['body_encoding']
        ];
      break;
      case 'amazon_ses_api':
        $attributes = [
          'access_key' => $data['access_key'],
          'secret_key' => !empty($data['secret_key']) ? Crypt::encrypt($data['secret_key']) : null,
          'region' => $data['region'],
          'process_reports' => $data['process_reports'],
          'amazon_configuration_set' => $data['amazon_configuration_set']
        ];
      break;
      case 'mailgun_api':
        $attributes = [
          'domain' => $data['domain'],
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null,
          'process_reports' => $data['process_reports']
        ];
      break;
      case 'elastic_email_api':
        $attributes = [
          'account_id' => $data['account_id'],
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null,
          'process_reports' => $data['process_reports']
        ];
      break;
      case 'mailjet_api':
        $attributes = [
          'api_key' => $data['api_key'],
          'secret_key' => !empty($data['secret_key']) ? Crypt::encrypt($data['secret_key']) : null,
          'process_reports' => $data['process_reports']
        ];
      break;
      case 'sendgrid_api':
        $attributes = [
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null,
          'process_reports' => $data['process_reports']
        ];
      break;
      case 'sparkpost_api':
      case 'mandrill_api':
      case 'sendinblue_api':
        $attributes = [
          'api_key' => !empty($data['api_key']) ? Crypt::encrypt($data['api_key']) : null
        ];
      break;
      default: 
        $attributes = null;
      break;
    }
    return json_encode($attributes);
  }

  /**
   * Retrun sending server fields respectively
  */
  public function getSendingServerFields($type, $action, $id=null)
  {
    if(empty($id)) {
      $settings = \DB::table('settings')->whereId(1)->select('sending_attributes')->first();
      $data = json_decode($settings->sending_attributes);
    } else {
      $data = json_decode(SendingServer::whereId($id)->value('sending_attributes'));
    }
    return view('sending_servers.attributes')->with(compact('type', 'action', 'data'));
  }

  /**
   * Retrun success/fail after send a test email
  */
  public function SendEmailTest(Request $request)
  {
    $request->validate([
      'email' => 'required|email|string|max:255',
      'sending_server_id' => 'required|integer'
    ]);
    $sending_server = SendingServer::whereId($request->sending_server_id)
      ->with('bounce')
      ->first();
    if($sending_server->status == 'Active') {
      $connection = Helper::configureSendingNode($sending_server->type, $sending_server->sending_attributes, 'mailcarry');

      if($connection['success']) {
        $message = Helper::configureEmailBasicSettings($sending_server);
        if(in_array($sending_server->type, Helper::sendingServersFramworkSuported())) {
          $message->setTo($request->email);

          if($request->broadcast_id) {
            $broadcast = \App\Models\Broadcast::whereId($request->broadcast_id)->first();
            $message->setSubject(Helper::decodeString($broadcast->email_subject));
            $message->setBody($broadcast->content_html, "text/html");
          } elseif($request->template_id) {
            $template = \App\Models\Template::whereId($request->template_id)->first();
            $message->setSubject(Helper::decodeString($template->name));
            $message->setBody($template->content, "text/html");
          } else {
            $message->setSubject("Test Email - {$sending_server->name}");
            $headers= $message->getHeaders();
            $headers->addTextHeader('List-Unsubscribe', "mail-to: {$sending_server->from_email}?subject=unsubscribe");
            $message->setBody('<!DOCTYPE html><html><head><title>Page Title</title></head><body><h1>This is a test email</h1><p>This is test email.</p></body></html>', "text/html");
            $message->setBody('This is a test email', "text/plain");

            $sending_domain = Helper::getSendingDomainFromEmail($sending_server->from_email);
            if($sending_server->type == 'smtp' && $sending_domain->verified_key) {
              $privateKey = $sending_domain->private_key;
              $selector = config('mc.dkim_selector');
              $message = Helper::attachSigner($message, $privateKey, $sending_domain->domain, $selector);
            }
          }
          try {
            $result = $connection['transport']->send($message);
            $status = 'Sent';
            $msg = __('app.msg_successfully_sent');
            $class = 'text-success';

            if($sending_server->type == 'mailjet_api') {
              if(!empty($result['ErrorMessage'])) {
                $msg = $result['ErrorMessage'];
                $status = 'Failed';
                $class = 'text-danger';
              }
            }

            $msg = "<span class='{$class}'>".$msg."</span>";
          } catch (\Exception $e) {
             $error = $e->getMessage();
             $status = 'Failed';
             $msg = "<span class='text-danger'>{$error}</span>";
          }
        } elseif($sending_server->type == 'sendgrid_api') {
          $message->addTo($request->email);
          if($request->broadcast_id) {
            $broadcast = \App\Models\Broadcast::whereId($request->broadcast_id)->first();
            $message->setSubject(Helper::decodeString($broadcast->email_subject));
            $message->addContent("text/html", $broadcast->content_html);
          } elseif($request->template_id) {
            $template = \App\Models\Template::whereId($request->template_id)->first();
            $message->setSubject(Helper::decodeString($template->name));
            $message->addContent("text/html", $template->content);
          } else {
            $message->setSubject("Test Email - {$sending_server->name}");
            $message->addContent("text/html", "This is a test email");
          }

          $sendgrid = new \SendGrid(Crypt::decrypt(json_decode($sending_server->sending_attributes)->api_key));
          try {
            $response = $sendgrid->send($message);
            // status start with 2 consider as sent
            if(substr($response->statusCode(), 1) == 2) {
              $status = 'Sent';
              $msg = "<span class='text-success'>".__('app.msg_successfully_sent')."</span>";
            } else {
              $status = 'Failed';
              $msg = "<span class='text-danger'>".json_decode($response->body())->errors[0]->message."</span>";
            }
            
          } catch (\Exception $e) {
            $error = $e->getMessage();
            $status = 'Failed';
            $msg = "<span class='text-danger'>{$error}</span>";
          }
        }

        if($status == 'Sent') {
          Helper::updateSendingServerCounters($sending_server->id);
        }
        return $msg;
      } else {
        return "<span class='text-danger'>{$connection['msg']}</span>";
      }
    } else {
      return "<span class='text-danger'>{$sending_server->notification}</span>";
    }
  }

  public function resetCounter($id)
  {
    return SendingServer::whereId($id)->update(['total_sent' => 0]);
  }
}
