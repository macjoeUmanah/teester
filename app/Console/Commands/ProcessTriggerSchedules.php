<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trigger;
use App\Models\TriggerSchedule;
use App\Models\AutoFollowupStat;
use App\Models\Broadcast;
use App\Models\SendingServer;
use App\Models\Contact;
use App\Models\Lists;
use App\Models\AutoFollowupStatLog;
use Helper;
use DB;

class ProcessTriggerSchedules extends Command
{

  protected $signature = 'mc:process-triggerschedules';
  protected $description = 'Send the emails that have been scheduled for tirggers';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Get active triggres and not in progress to matain speed if defined
    $triggers = Trigger::whereInProgress(false)
      ->whereActive('Yes')
      ->whereAction('send_campaign')
      ->get();

    if(!empty($triggers)) {
      // Get Settings
      $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
      $tracking = $settings->tracking == 'enabled' ? true : false;
      $app_url = $settings->app_url;

      foreach($triggers as $trigger) {
        // Next cron will not enterin this trigger sending until finish
        Trigger::whereId($trigger->id)->update(['in_progress' => true]);

        // Save data for stats if not exist
        if(!AutoFollowupStat::whereAutoFollowupId($trigger->id)->exists()) {
          $auto_followup_stat = AutoFollowupStat::create([
            'auto_followup_id' => $trigger->id,
            'auto_followup_name' => $trigger->name,
            'schedule_by' => \App\Models\User::getUserValue($trigger->user_id, 'name'),
            'app_id' => $trigger->app_id,
            'user_id' => $trigger->user_id,
          ]);
          $auto_followup_stat_id = $auto_followup_stat->id;
        } else {
          $auto_followup_stat_id = AutoFollowupStat::whereAutoFollowupId($trigger->id)->value('id');
        }

        $sending_speed = json_decode($trigger->attributes)->sending_speed;
        if(!empty($sending_speed) && $sending_speed == 'limited') {
          $sending_limit = json_decode($trigger->attributes)->sending_limit;
          $wait = floor(3600 / $sending_limit); // divide on 1 hour
        } else {
          $wait = false;
        }

        $query = TriggerSchedule::whereTriggerId($trigger->id)->where('send_datetime', '<=', \Carbon\Carbon::now());
        $query->chunk(1000, function($trigger_schedule) use ($settings, $tracking, $app_url, $auto_followup_stat_id, $trigger, $wait) {

          foreach($trigger_schedule as $schedule) {

            // stop sending if trigger is inactive
            if(Trigger::whereId($trigger->id)->value('active') == 'No') {
              Trigger::whereId($trigger->id)->update(['in_progress' => false]);
              exit;
            }
            // If bounced
            $contact = Contact::whereId($schedule->contact_id)->first();

            // If already sent to a contact
            if(AutoFollowupStatLog::whereAutoFollowupStatId($auto_followup_stat_id)->whereEmail($contact->email)->exists()){
              // Delete data from trigger_schedules table after processed
              TriggerSchedule::whereId($schedule->id)->delete();
              continue;
            }

            if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) {
              // Delete data from trigger_schedules table after processed
              TriggerSchedule::whereId($schedule->id)->delete();
              continue;
            }

            // Get broadcast
            $broadcast = Broadcast::whereId($schedule->broadcast_id)->first();

            // Get Sending Sever
            try {
              $sending_server = SendingServer::whereStatus('Active')->whereId($schedule->sending_server_id)->with('bounce')->first()->toArray();
            } catch(\Exception $e) {
              continue;
            }

            // If sending server is inactive
            if(empty($sending_server)) continue;

            $connection = Helper::configureSendingNode($sending_server['type'], $sending_server['sending_attributes']);

            if($connection['success']) {
              $sending_domain = Helper::getSendingDomainFromEmail($sending_server['from_email']);
              // if no domain found
              try {
                $domain = $sending_domain->protocol.$sending_domain->domain;
              } catch(\Exception $e) {
                continue;
              }
              $message_id = Helper::getCustomMessageID($domain);

              if(!empty($sending_server['tracking_domain'])) {
                $tracking_domain = $sending_server['tracking_domain'];
              } else {
                $tracking_domain = Helper::getAppURL();
              }


              // Replace spintags
              $content = Helper::replaceSpintags($broadcast->content_html);
              $email_subject = Helper::replaceSpintags($broadcast->email_subject);

              // Replace custom field
              $content = Helper::replaceCustomFields($content, $contact->customFields);
              $email_subject = Helper::replaceCustomFields($email_subject, $contact->customFields);

              $from_name = Helper::replaceSpintags($sending_server['from_name']);
              // Data that will be use to replce the system variables
              $data_values = [
                'broadcast-id'   => $broadcast->id,
                'broadcast-name' => $broadcast->name,
                'sender-name'    => $from_name,
                'sender-email'   => $sending_server['from_email'],
                'domain'         => $tracking_domain,
                'message-id'     => $message_id,
              ];

              // Replace system variables
              $content = Helper::replaceSystemVariables($contact, $content, $data_values);

              // Create AutoFollowupStatLog and the id would be use to track the email
              $list_name = Lists::whereId($contact->list_id)->value('name');
              $auto_followup_stat_log_data = [
                'auto_followup_stat_id' => $auto_followup_stat_id,
                'message_id' => $message_id,
                'email' => $contact->email,
                'list' => $list_name,
                'broadcast' => $broadcast->name,
                'sending_server' => $sending_server['name'],
              ];

              $auto_followup_stat_log = AutoFollowupStatLog::create($auto_followup_stat_log_data);

              if($tracking) {

                // click tracking should be before track_opens becuase don't want to convert that url
                $content = Helper::convertLinksForClickTracking($auto_followup_stat_log->id, $tracking_domain, $content, $app_url, '/af/click/');

                // Make open tracking url and pixel d=drip
                $track_open = $tracking_domain.'/af/open/'.base64_encode($auto_followup_stat_log->id);
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
                  $message->setFrom($sending_server['from_email'], $sending_server['from_name']);
                  $message->setId($message_id);
                  $message->setTo($contact->email);
                  $message->setSubject($email_subject);
                  $message->addReplyTo($sending_server['reply_email']);
                  if(!empty($sending_server['bounce']['email'])) {
                    $message->setReturnPath($sending_server['bounce']['email']);
                  }
                  // will be use for bounce, span, filters etc.
                  $headers= $message->getHeaders();
                  // Header will use to process the bounces and fbls etc.
                  $headers->addTextHeader('MC-Type-ID', "autofollowup-{$auto_followup_stat_log->id}-{$trigger->app_id}");

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
                    $headers->addTextHeader('x-job', "autofollowup-{$auto_followup_stat_log->id}-{$trigger->app_id}");
                  }

                  $message->setBody($content, 'text/html');
                  
                  if($sending_server['type'] == 'smtp' && $sending_domain->verified_key) {
                    $privateKey = $sending_domain->private_key;
                    $selector = $sending_domain->dkim;

                    $message->attachSigner((new \Swift_Signers_DKIMSigner($privateKey, $sending_domain->domain, $selector))
                      ->setBodyCanon('simple')
                      ->ignoreHeader('Return-Path')
                      ->setHeaderCanon('relaxed')
                      ->setHashAlgorithm('rsa-sha1')
                    );
                  }

                  try {
                    $connection['transport']->send($message);
                    $status = 'Sent';
                  } catch(\Exception $e) {
                    \Log::error('mc:process-autofollowup => '.$e->getMessage());
                    $status = 'Failed';
                  }
              } elseif($sending_server['type'] == 'sendgrid_api') {
                $message = new \SendGrid\Mail\Mail();
                $message->setFrom($sending_server['from_email'], $sending_server['from_name']);
                $message->setReplyTo($sending_server['reply_email']);
                $message->addTo($contact->email);
                $message->setSubject($email_subject);
                $message->addContent("text/html", $content);
                // Custom variable that will use to process the devlivery reports
                $message->addCustomArg('mc_message_id', $message_id);

                $sendgrid = new \SendGrid(\Crypt::decrypt(json_decode($sending_server['sending_attributes'])->api_key));
                try {
                  $response = $sendgrid->send($message);
                  // status start with 2 consider as sent
                  if(substr($response->statusCode(), 1) == 2) {
                    $status = 'Sent';
                  } else {
                    $status = 'Failed';
                  }
                } catch(\Exception $e) {
                  \Log::error('mc:process-autofollowup => '.$e->getMessage());
                  $status = 'Failed';
                }
              }

              // Should be check in both case
              //if($status == 'Sent') {
                $sending_server_data = Helper::updateSendingServerCounters($sending_server['id']);
              //}

              // Update status
              AutoFollowupStatLog::whereId($auto_followup_stat_log->id)->update(['status' => $status]);

              // Delete data from trigger_schedules table after processed
              TriggerSchedule::whereId($schedule->id)->delete();

              if($wait) sleep($wait);

            } else {
              // If sending server connection failed then need to update it as system inactive
              // Removing single and double quote due to output issue with js alert at frontend 
              SendingServer::whereId($sending_server['id'])->update(['status' => 'System Inactive', 'notification' => str_replace( ["'",'"'], '', explode('.',$connection['msg'])[0] )]);
            }
          } // End foreach contacts
        });

        // Next cron should enterin this trigger sending now
        Trigger::whereId($trigger->id)->update(['in_progress' => false]);
      } // End foreach triggers
    } // If triggers are not empty
  }
}
