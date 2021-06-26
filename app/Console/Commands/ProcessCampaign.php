<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduleCampaign;
use App\Models\ScheduleCampaignStat;
use App\Models\ScheduleCampaignStatLog;
use App\Models\SendingServer;
use App\Models\Contact;
use Helper;
use DB;

class ProcessCampaign extends Command
{
  protected $signature = 'mc:process-campaign {id?} {thread_no?}';
  protected $description = 'Process campaigns that have been scheduleds';

  public function __construct()
  {
      parent::__construct();
  }

  public function handle()
  {

    // Save timestamp when cron last executed
    $carbon = new \Carbon\Carbon();
    DB::table('settings')->whereId(config('mc.app_id'))->update([
      'attributes->cron_timestamp' => $carbon->now(),
    ]);

    $id = $this->argument('id');
    if($id) {
      $thread_no = $this->argument('thread_no');

      // Get a scheduled campaign need to send
      $schedule = ScheduleCampaign::findOrFail($id);

      // Check sending status and set status to completed
      $this->checkCampaignStatus($schedule->id);

      // For some reason if thread_no > total_threads
      if($thread_no > $schedule->total_threads) {
        ScheduleCampaign::whereId($schedule->id)->update(['thread_no' => 1, 'status' => 'Resume']);
        exit;
      }

      // If campaign is set for hourly limit then updte the time to 1 hour laterl send further
      if(json_decode($schedule->sending_speed)->limit) {
        $next_datetime = $carbon->parse($carbon->now(), config('app.timezone'))->addHour(1);
        ScheduleCampaign::whereId($schedule->id)->update(['status' => 'RunningLimit', 'send_datetime' => $next_datetime]);
      } else {
        $this->setScheduleStatus($schedule->id, 'Running');
      }

      $this->sendCampaign($schedule, $thread_no);


    } else {
      $this->processCampaign();
    }
  }

  /**
   * Send campaign to subscribers
  */
  protected function sendCampaign($schedule, $thread_no)
  {
    // Retrun array of sending servers
    $sending_servers = SendingServer::getActiveSeningServers(explode(',', $schedule->sending_server_ids), 'array');

    // If no sending server then no need to do anything
    if(empty($sending_servers)) {
      $this->setScheduleStatus($schedule->id, 'System Paused');
    }

    // Will be use to reset the sending_server array when  all picked
    $sending_servers_data = $sending_servers;

    // Get schedule stat info will be use later
    $schedule_stat = ScheduleCampaignStat::whereScheduleCampaignId($schedule->id)->first();

    $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
    $tracking = $settings->tracking == 'enabled' ? true : false;
    $app_url = $settings->app_url;

    // Either admin campaing or client campaing
    if($schedule->app_id == config('mc.app_id')) {
      $mail_headers = json_decode($settings->mail_headers, true);
    } else {
      $mail_headers = json_decode(DB::table('client_settings')->select('mail_headers')->whereAppId($schedule->app_id)->value('mail_headers'), true);
    }
    

    $limit = json_decode($schedule->sending_speed)->limit;
    if(!empty($limit) && trim($limit) != '') {
      $condition = $thread_no;
      $wait = floor(3600 / $limit); // divide on 1 hour
    } else {
      $condition = $schedule->total_threads;
      $wait = false;
    }

    // Need to execute the loop according to the threads start with thread no
    for($file_no=$thread_no; $file_no<=$condition; $file_no+=$schedule->threads) {
      $schedule->increment('thread_no');

      $path_schedule_campaign = str_replace('[user-id]', $schedule->user_id, config('mc.path_schedule_campaign'));
      $file = $path_schedule_campaign.$schedule->id.DIRECTORY_SEPARATOR. $file_no . '.csv';

      if(file_exists($file)) {
        $file_offsets = DB::table('file_offsets')->where('file', $file)->first();
        // Get file offset
        $offset_file = empty($file_offsets) ? 0 : $file_offsets->offset;
        if($offset_file) {
          // Delete entry after picking up offset may be use in next time
          DB::table('file_offsets')->where('file', $file)->delete();
        }
        $reader = \League\Csv\Reader::createFromPath($file, 'r');
        // Make associative array with names and skipp header
        $reader->setHeaderOffset(0);
        // It may possible campaing paused in past then it wil continue form the same recored
        $stmt = (new \League\Csv\Statement())->offset($offset_file);
        //$contacts_csv = $reader->getRecords();
        $contacts_csv = $stmt->process($reader);

        $total_records = Helper::getCsvCount($file);

        foreach ($contacts_csv as $offset => $contact_csv) {
          // Need to stop the campaign instantally as campaign status is paused
          // Decrement should work for latest value
          $schedule = ScheduleCampaign::findOrFail($schedule->id);
          if ($schedule->status == 'Paused' || $schedule->status == 'System Paused') {
            // Store record no into db to execuet the file from same location instead from start when campaing resumed
            DB::table('file_offsets')->insert([
              'file' => $file,
              'offset' => --$offset // Minus 1 before to save other wise next recored will be picked when resumed
            ]);

            // The same file should be select when resumed
            $schedule->decrement('thread_no', 1);
            if($limit) {
              $carbon = new \Carbon\Carbon();
              $send_datetime = $carbon->parse($carbon->now(), config('app.timezone'));
              ScheduleCampaign::whereId($schedule->id)->update(['send_datetime' => $send_datetime]);
            }
            // Stop Campaign sending
            exit;
          }

          // Check if already sent
          if(ScheduleCampaignStatLog::whereScheduleCampaignStatId($schedule_stat->id)->whereEmail($contact_csv['EMAIL'])->exists()) continue;

          // Sending servers info that assigned previously to reset the sending servers when all picked
          if(empty($sending_servers)) {
            $sending_servers = $sending_servers_data;
          }

          // get sending server
          $sending_server = array_shift($sending_servers);

          $sending_domain = Helper::getSendingDomainFromEmail($sending_server['from_email']);
          // if no domain found
          try {
            $domain = $sending_domain->protocol.$sending_domain->domain;
          } catch(\Exception $e) {
            continue;
          }
          $message_id = Helper::getCustomMessageID($domain);

          // Try to connect with SendingServer
          $connection = Helper::configureSendingNode($sending_server['type'], $sending_server['sending_attributes'], $message_id);
          if($connection['success']) {
            $contact = Contact::whereId($contact_csv['ID'])->with('customFields')->first();

            if(!empty($sending_server['tracking_domain'])) {
              $tracking_domain = $sending_server['tracking_domain'];
            } else {
              $tracking_domain = Helper::getAppURL();
             // $tracking_domain = "{$sending_domain->protocol}{$sending_domain->tracking}.{$sending_domain->domain}";
            }

            $from_name = Helper::replaceSpintags($sending_server['from_name']);
            // Data that will be use to replce the system variables
            $data_values = [
              'broadcast-id'   => $contact_csv['BROADCAST_ID'],
              'broadcast-name' => $contact_csv['BROADCAST_NAME'],
              'sender-name'    => $from_name,
              'sender-email'   => $sending_server['from_email'],
              'domain'         => $tracking_domain,
              'message-id'     => $message_id,
            ];

            // Replace system variables
            $subject = Helper::replaceSystemVariables($contact, $contact_csv['EMAIL_SUBJECT'], $data_values);
            $content = Helper::replaceSystemVariables($contact, $contact_csv['BROADCAST'], $data_values);

            // Create ScheduleCampaignStatLog and the id would be use to track the email
            $schedule_campaign_stat_log_data = [
              'schedule_campaign_stat_id' => $schedule_stat->id,
              'message_id' => $message_id,
              'email' => $contact_csv['EMAIL'],
              'list' => $contact_csv['LIST'],
              'broadcast' => $contact_csv['BROADCAST_NAME'],
              'sending_server' => $sending_server['name'],
            ];
            $schedule_campaign_stat_log = ScheduleCampaignStatLog::create($schedule_campaign_stat_log_data);

            // If tracking is enabled, for TEXT format the tracing will not work
            if($tracking && $contact_csv['FORMAT'] == 'HTML') {
              // click tracking should be before track_opens becuase don't want to convert that url
              $content = Helper::convertLinksForClickTracking($schedule_campaign_stat_log->id, $tracking_domain, $content, $app_url, '/click/');

              // Make open tracking url and pixel
              $track_open = $tracking_domain.'/open/'.base64_encode($schedule_campaign_stat_log->id);
              $content .= "<div style='float:left; clear:both; font-family:Arial; margin:40px auto; width:100%; line-height:175%; font-size:11px; color:#434343'><img border='0' src='".$track_open."' width='1' height='1' alt=''></div>";
            }

            // If sending type that supported by framework will be send with a same way
            if(in_array($sending_server['type'], Helper::sendingServersFramworkSuported())) {
                $message = new \Swift_Message();
                $body_encoding = json_decode($sending_server['sending_attributes'])->body_encoding ?? null;
                if(!empty($body_encoding) && $body_encoding == 'base64') {
                  $message->setEncoder(new \Swift_Mime_ContentEncoder_Base64ContentEncoder());
                } elseif(!empty($body_encoding) && $body_encoding == '7-bit') {
                  $message->setEncoder(new \Swift_Mime_ContentEncoder_PlainContentEncoder('7bit'));
                } else {
                  // quoted-printable default
                  $message->setEncoder(new \Swift_Mime_ContentEncoder_NativeQpContentEncoder());
                }
                $message->setFrom($sending_server['from_email'], $from_name);
                $message->setId($message_id);
                $message->setTo($contact_csv['EMAIL']);
                $message->setSubject($subject);
                $message->addReplyTo($sending_server['reply_email']);
                if(!empty($sending_server['bounce']['email'])) {
                  $message->setReturnPath($sending_server['bounce']['email']);
                }
                // will be use for bounce, span, filters etc.
                $headers= $message->getHeaders();
                // Header will use to process the bounces and fbls etc.
                $headers->addTextHeader('MC-Type-ID', "campaign-{$schedule_campaign_stat_log->id}-{$schedule->app_id}");

                // Required header for good inboxing
                $headers->addTextHeader('List-Unsubscribe', "mail-to: {$sending_server['from_email']}?subject=unsubscribe");

                // Header will be use to process reports for Amazon
                if($sending_server['type'] == 'amazon_ses_api' && !empty(json_decode($sending_server['sending_attributes'])->process_reports) && json_decode($sending_server['sending_attributes'])->process_reports == 'yes') {
                  if(!empty(json_decode($sending_server['sending_attributes'])->amazon_configuration_set)) {
                    $headers->addTextHeader('X-SES-CONFIGURATION-SET', json_decode($sending_server['sending_attributes'])->amazon_configuration_set);
                  }
                }


                // Header will be use to process bounce for PMTA
                if($sending_server['pmta']) {
                  $headers->addTextHeader('x-job', "campaign-{$schedule_campaign_stat_log->id}-{$schedule->app_id}");
                }

                if(!empty($mail_headers)) {
                  foreach($mail_headers as $header_key => $header_value) {
                    $header_value = Helper::replaceSpintags($header_value);
                    $header_value = Helper::replaceCustomFields($header_value, $contact->customFields);
                    $header_value = Helper::replaceSystemVariables($contact, $header_value, $data_values);

                    $header_key = Helper::replaceHyphen($header_key);

                    $message->getHeaders()->addTextHeader($header_key, $header_value);
                  }
                }
                $contact_csv['FORMAT'] == 'HTML' ? $message->setBody($content, 'text/html') : $message->setBody($content, 'text/plain');
                
                if($sending_server['type'] == 'smtp' && $sending_domain->verified_key) {
                  $privateKey = $sending_domain->private_key;
                  $selector = $sending_domain->dkim;

                  $message = Helper::attachSigner($message, $privateKey, $sending_domain->domain, $selector);
                }

                // Will be check either need to load sending servers again or not
                $load_sending_servers = false;
                try {
                  $connection['transport']->send($message);
                  $status = 'Sent';
                } catch(\Exception $e) {
                  \Log::error('mc:process-campaign-send => '.$e->getMessage());
                  $status = 'Failed';
                }
            } elseif($sending_server['type'] == 'sendgrid_api') {
              $message = new \SendGrid\Mail\Mail();
              $message->setFrom($sending_server['from_email'], $from_name);
              $message->setReplyTo($sending_server['reply_email']);
              $message->addTo($contact_csv['EMAIL']);
              $message->setSubject($subject);
              $contact_csv['FORMAT'] == 'HTML' ? $message->addContent("text/html", $content) : $message->addContent("text/plain", $content);
              // Custom variable that will use to process the devlivery reports
              $message->addCustomArg('mc_message_id', $message_id);

              $sendgrid = new \SendGrid(\Crypt::decrypt(json_decode($sending_server['sending_attributes'])->api_key));
              $load_sending_servers = false;
              try {
                $response = $sendgrid->send($message);
                // status start with 2 consider as sent
                if(substr($response->statusCode(), 1) == 2) {
                  $status = 'Sent';
                } else {
                  $status = 'Failed';
                }
              } catch(\Exception $e) {
                \Log::error('mc:process-campaign-send-sendgrid => '.$e->getMessage());
                $status = 'Failed';
              }
            }

            $sending_server_data = Helper::updateSendingServerCounters($sending_server['id']);

            if($sending_server_data['sending_server_paused']) {
              $load_sending_servers = true;
            }

            // update sent counter with 1 for both tables
            $schedule->increment('sent');
            $schedule_stat->increment('sent');

            // Update status
            ScheduleCampaignStatLog::whereId($schedule_campaign_stat_log->id)->update(['status' => $status]);

            // Check sending status and set status to completed
            $this->checkCampaignStatus($schedule->id);

          } else {
            // If sending server connection failed then need to update it as system inactive
            // Removing single and double quote due to output issue with js alert at frontend 
            SendingServer::whereId($sending_server['id'])->update(['status' => 'System Inactive', 'notification' => str_replace( ["'",'"'], '', explode('.',$connection['msg'])[0] )]); 

            $load_sending_servers = true;
          }

          if($load_sending_servers) {
            // Retrun new array of sending servers after make a sending server as system inactive
            $sending_servers_data = SendingServer::getActiveSeningServers(explode(',', $schedule->sending_server_ids), 'array');

            // If no sending server then no need to do anything
            if(empty($sending_servers_data)) {
              $this->setScheduleStatus($schedule->id, 'System Paused');
            }
          }

          if($wait) sleep($wait);
        } // End foreach $contacts

        // Check sending status and set status to completed
        $this->checkCampaignStatus($schedule->id);
        try {
          // Delete File after process
          unlink($file);
        } catch (\Exception $e) {
          \Log::error('mc:process-campaign => '.$e->getMessage());
        }
      }
    } // End for loop $threads
  } // End Function

  /**
   * Needs to send parallel request so doing this
  */
  protected function processCampaign()
  {
    Helper::getUrl(Helper::getAppURL().'/process_campaign');
  }

  /**
   * Check sending status of campign if all sent the set status to completed
  */
  protected function checkCampaignStatus($id)
  {
    // picking up fresh entries
    $schedule = ScheduleCampaign::findOrFail($id);
    if($schedule->sent >= $schedule->scheduled) {
      ScheduleCampaignStat::whereScheduleCampaignId($schedule->id)->update(['end_datetime' => \Carbon\Carbon::now()]);
      ScheduleCampaign::whereId($schedule->id)->update(['status' => 'Completed']);
      exit;
    }
  }

  /**
   * Update scheduled campaign status
  */
  protected function setScheduleStatus($id, $status)
  {
    ScheduleCampaign::whereId($id)->update(['status' => $status]);
  }
}
