<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SendingServer;
use Helper;
use DB;

class CallbackController extends Controller
{
  public function __construct(Request $request)
  {
    /*$callback = $request->all();
    $request_data = print_r($callback, true);
    $str = "Request Data ".date("Y-m-d H:i:s")." \n $request_data";
    $file_path = storage_path().DIRECTORY_SEPARATOR.'callback_request.txt';
    $fp = fopen($file_path, 'a');
    fwrite($fp, $str);
    fclose($fp);*/

    // Get Amazon Callback
    $callback = json_decode(file_get_contents('php://input'), true);
    if(!empty($callback) && (!empty($callback['SubscribeURL']) || !empty($callback['Message']))) {
      $this->amazon($callback);
    }
  }

  // MailGun Callback
  public function mailgun(Request $request)
  {
    $callback = $request->all();
    $callback['message_id'] = $callback['event-data']['message']['headers']['message-id'] ?? null;
    if($callback['message_id']) {
      list($table, $stat_id, $to_email, $sending_server, $section, $app_id) = Helper::statMessageDetail($callback['message_id']);
      $sending_attributes = json_decode(SendingServer::whereName($sending_server)->whereAppId($app_id)->value('sending_attributes'));
      // If process is enabled within sending server settings
      if(!empty($sending_attributes->process_reports) && $sending_attributes->process_reports == 'yes') {
        if($stat_id) {
          $callback['event'] = $callback['event-data']['event'] ?? null;
          $short_detail = $full_detail = $callback['event-data']['delivery-status']['description'] ?? $callback['event-data']['delivery-status']['message'] ?? null;

          $status = null;
          if($callback['event'] == 'failed' || $callback['event'] == 'bounce' || $callback['event'] == 'suppress-bounce') {
            $code = $callback['event-data']['delivery-status']['code'] ?? '511';
            $type = Helper::bouceCodes($code)['type'] ?? 'Hard';
            // Save bounce data
            Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
            $status = 'Bounced';
          } elseif($callback['event'] == 'complained') {
            // Save spam data
            Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $app_id);
            $status = 'Spammed';
          }

          if($status) {
            // Update email status
            DB::table($table)->whereId($stat_id)->update(['status' => $status]);
          }
        }
      }
    }
    return response()->json(['success' => true]);
  }

  // SendGrid Callback
  public function sendGrid(Request $request)
  {
    $callbacks = $request->all();
    foreach ($callbacks as $callback) {
      // no need to chek processed request to reduece checks, because each email has processed callback data
      if($callback['event'] == 'processed') continue;

      $callback['message_id'] = $callback['mc_message_id'] ?? null;
      if($callback['message_id']) {
        list($table, $stat_id, $to_email, $sending_server, $section, $app_id) = Helper::statMessageDetail($callback['message_id']);
        $sending_attributes = json_decode(SendingServer::whereName($sending_server)->whereAppId($app_id)->value('sending_attributes'));
        // If process is enabled within sending server settings
        if(!empty($sending_attributes->process_reports) && $sending_attributes->process_reports == 'yes') {
          if($stat_id) {
            $short_detail = $full_detail = $callback['reason'] ?? null;

            $status = null;
            if($callback['event'] == 'bounce' || $callback['event'] == 'deferred' || 
              $callback['event'] == 'dropped' || $callback['event'] == 'blocked') {
              $code = $callback['status'] ?? '5.1.1';
              $type = Helper::bouceCodes($code)['type'] ?? 'Hard';
              // Save bounce data
              Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
              $status = 'Bounced';
            } elseif($callback['event'] == 'complained') {
              // Save spam data
              Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $app_id);
              $status = 'Spammed';
            }

            if($status) {
              // Update email status
              DB::table($table)->whereId($stat_id)->update(['status' => $status]);
            }
          }
        }
      }
    }
    return response()->json(['success' => true]);
  }

  // Mailjet Callback
  public function mailjet(Request $request)
  {
    $callbacks = $request->all();
    foreach ($callbacks as $callback) {
      $callback['message_id'] = $callback['CustomID'] ?? null;
      if($callback['message_id']) {
        list($table, $stat_id, $to_email, $sending_server, $section, $app_id) = Helper::statMessageDetail($callback['message_id']);
        $sending_attributes = json_decode(SendingServer::whereName($sending_server)->whereAppId($app_id)->value('sending_attributes'));
        // If process is enabled within sending server settings
        if(!empty($sending_attributes->process_reports) && $sending_attributes->process_reports == 'yes') {
          if($stat_id) {
            $callback['event'] = $callback['event'] ?? null;
            $short_detail = $full_detail = $callback['error'] ?? null;

            $status = null;
            if($callback['event'] == 'bounce' || $callback['event'] == 'blocked') {
              $code = '5.1.1';
              $type = Helper::bouceCodes($code)['type'] ?? 'Hard';
              // Save bounce data
              Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
              $status = 'Bounced';
            } elseif($callback['event'] == 'spam') {
              // Save spam data
              Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $app_id);
              $status = 'Spammed';
            }

            if($status) {
              // Update email status
              DB::table($table)->whereId($stat_id)->update(['status' => $status]);
            }
          }
        }
      }
    }
    return response()->json(['success' => true]);
  }

  // ElasticEmail Callback
  public function elasticEmail(Request $request)
  {
    $callbacks = $request->all();
    foreach ($callbacks as $callback) {
      $callback['message_id'] = $callback['postback'] ?? null;
      if($callback['message_id']) {
        list($table, $stat_id, $to_email, $sending_server, $section, $app_id) = Helper::statMessageDetail($callback['message_id']);
        $sending_attributes = json_decode(SendingServer::whereName($sending_server)->whereAppId($app_id)->value('sending_attributes'));
        // If process is enabled within sending server settings
        if(!empty($sending_attributes->process_reports) && $sending_attributes->process_reports == 'yes') {
          if($stat_id) {
            $callback['event'] = $callback['status'] ?? null;
            $short_detail = $full_detail = $callback['category'] ?? null;

            $status = null;
            if($callback['event'] == 'Error' || $callback['event'] == 'Bounce') {
              $code = '5.1.1';
              $type = Helper::bouceCodes($code)['type'] ?? 'Hard';
              // Save bounce data
              Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
              $status = 'Bounced';
            } elseif($callback['event'] == 'Complaints') {
              // Save spam data
              Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $app_id);
              $status = 'Spammed';
            }

            if($status) {
              // Update email status
              DB::table($table)->whereId($stat_id)->update(['status' => $status]);
            }
          }
        }
      }
    }
    return response()->json(['success' => true]);
  }

  // Amazon Callback
  public function amazon($callback=null)
  {
    // Get Amazon callback response
    if(!empty($callback['SubscribeURL'])) {
      $file_path = storage_path().DIRECTORY_SEPARATOR."amazonsns.txt";
      $fp = fopen($file_path, 'w');
      fwrite($fp, print_r($callback['SubscribeURL'], true));
      fclose($fp);
    } elseif(!empty($callback['Message'])) {
      /*$file_path = storage_path().DIRECTORY_SEPARATOR."amazonses.txt";
      $fp = fopen($file_path, 'a');
      fwrite($fp, print_r($callback, true));
      fclose($fp);*/

      if(!empty($callback)) {
        $message = json_decode($callback['Message'], true);
        $callback['message_id'] = trim($message['mail']['headers'][1]['value']) ?? null; // message id
        if($callback['message_id']) {
          // remove characters from message-id
          $callback['message_id'] = str_replace(['<', '>'], '', $callback['message_id']);
          list($table, $stat_id, $to_email, $sending_server, $section, $app_id) = Helper::statMessageDetail($callback['message_id']);
          $sending_attributes = json_decode(SendingServer::whereName($sending_server)->whereAppId($app_id)->value('sending_attributes'));
          // If process is enabled within sending server settings
          if(!empty($sending_attributes->process_reports) && $sending_attributes->process_reports == 'yes') {
            if($stat_id) {
              $callback['event'] = trim($message['notificationType']) ?? (trim($message['eventType']) ?? null);
              $short_detail = $full_detail = !empty($message['bounce']['bouncedRecipients'][0]['diagnosticCode']) ?? null;

              $status = null;
              if($callback['event'] == 'Bounce' || $callback['event'] == 'Reject' || $callback['event'] == 'Rendering Failure') {
                $code =  !empty($message['bounce']['bouncedRecipients'][0]['status']) ?? '5.1.1';
                $type = Helper::bouceCodes($code)['type'] ?? 'Hard';
                // Save bounce data
                Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
                $status = 'Bounced';
              } elseif($callback['event'] == 'Complaint') {
                // Save spam data
                Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $app_id);
                $status = 'Spammed';
              }

              if($status) {
                // Update email status
                DB::table($table)->whereId($stat_id)->update(['status' => $status]);
              }
            }
          }
        }
      }
    }
    return response()->json(['success' => true]);
  }

}