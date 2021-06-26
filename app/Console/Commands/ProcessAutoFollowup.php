<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AutoFollowup;
use App\Models\AutoFollowupStat;
use App\Models\AutoFollowupStatLog;
use App\Models\Segment;
use App\Models\Lists;
use Helper;
use DB;

class ProcessAutoFollowup extends Command
{
  protected $signature = 'mc:process-autofollowup';
  protected $description = 'Process auto followup that have been set';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Get active auto followups
    $auto_followups = AutoFollowup::whereActive('Yes')->get();

    if(!empty($auto_followups)) {
      foreach($auto_followups as $auto_followup) {

        // Save data for stats if not exist
        if(!AutoFollowupStat::whereId($auto_followup->id)->exists()) {
          $auto_followup_stat = AutoFollowupStat::create([
            'auto_followup_id' => $auto_followup->id,
            'auto_followup_name' => $auto_followup->name,
            'schedule_by' => \App\Models\User::getUserValue($auto_followup->user_id, 'name'),
            'app_id' => $auto_followup->app_id,
            'user_id' => $auto_followup->user_id,
          ]);
          $auto_followup_stat_id = $auto_followup_stat->id;
        } else {
          $auto_followup_stat_id = AutoFollowupStat::whereId($auto_followup->id)->value('id');
        }

        // Get broadcast
        $broadcast = \App\Models\Broadcast::whereId($auto_followup->broadcast_id)->first();

        try {
          // Get sending server
          $sending_server = \App\Models\SendingServer::getActiveSeningServers([$auto_followup->sending_server_id], 'array')[0];
        } catch(\Exception $e) {
          AutoFollowup::whereId($auto_followup->id)->update(['active' => 'No']);
          \Log::error('mc:process-autofollowup => '.$e->getMessage());
          exit;
        }

        // Get segment
        $segment = Segment::whereId($auto_followup->segment_id)->first();

        try {
          if($segment->type == 'List') {
            $query = Segment::querySegmentList($segment->attributes);
            $query->orderBy('id', 'DESC')->distinct();
          } elseif($segment->type == 'Campaign') {
            $query = Segment::querySegmentCampaign($segment->attributes, $segment->user_id);
            $query->orderBy('schedule_campaign_stat_logs.id', 'DESC')->distinct();
          }
        } catch(\Exception $e) {
          \Log::error('mc:process-autofollowup => '.$e->getMessage());
        }

        // Get segmented data with 1000 limit
        $query->chunk(1000, function($contacts) use ($auto_followup, $broadcast, $sending_server, $auto_followup_stat_id) {
          // Get Settings
          $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
          $tracking = $settings->tracking == 'enabled' ? true : flase;
          $app_url = $settings->app_url;

          foreach($contacts as $contact) {

            // If already sent to a contact
            if(AutoFollowupStatLog::whereAutoFollowupStatId($auto_followup->id)->whereEmail($contact->email)->exists()) continue;

            // If bounced
            if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) continue;

            $connection = Helper::configureSendingNode($sending_server['type'], $sending_server['sending_attributes']);
            if($connection['success']) {
              $sending_domain = Helper::getSendingDomainFromEmail($sending_server['from_email']);
              $domain = $sending_domain->protocol.$sending_domain->domain;
              $message_id = Helper::getCustomMessageID($domain);


              // Replace spintags
              $content = Helper::replaceSpintags(Helper::decodeString($broadcast->content_html));
              $email_subject = Helper::replaceSpintags(Helper::decodeString($broadcast->email_subject));

              // Replace custom field
              $content = Helper::replaceCustomFields($content, $contact->customFields);
              $email_subject = Helper::replaceCustomFields($email_subject, $contact->customFields);

              // Data that will be use to replce the system variables
              $data_values = [
                'broadcast-id'   => $broadcast->id,
                'broadcast-name' => $broadcast->name,
                'sender-name'    => $sending_server['from_name'],
                'sender-email'   => $sending_server['from_email'],
                'domain'         => $domain,
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
                $tracking_domain = $sending_domain->verified_tracking 
                  ? "{$sending_domain->protocol}{$sending_domain->tracking}.{$sending_domain->domain}"
                  : $app_url;

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
                  $message->setReturnPath($sending_server['bounce']['email']);
                  // will be use for bounce, span, filters etc.
                  $headers= $message->getHeaders();
                  // Header will use to process the bounces and fbls etc.
                  $headers->addTextHeader('MC-Type-ID', "autofollowup-{$auto_followup_stat_log->id}-{$auto_followup->app_id}");

                  // Header will be use to process bounce for PMTA
                  if($sending_server['pmta']) {
                    $headers->addTextHeader('x-job', "autofollowup-{$auto_followup_stat_log->id}-{$auto_followup->app_id}");
                  }

                  $message->setBody($content, 'text/html');
                  
                  if($sending_server['type'] == 'smtp' && $sending_domain->verified_key) {
                    $privateKey = $sending_domain->private_key;
                    $selector = $sending_domain->dkim;

                    $message->attachSigner((new \Swift_Signers_DKIMSigner($privateKey, $domain, $selector))
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
            } else {
              // If sending server connection failed then need to update it as system inactive
              // Removing single and double quote due to output issue with js alert at frontend 
              SendingServer::whereId($sending_server['id'])->update(['status' => 'System Inactive', 'notification' => str_replace( ["'",'"'], '', explode('.',$connection['msg'])[0] )]);

              // Exit becuase we only have one sending server
              exit;
            }
          }
        });
      }
      
    }
  }
}
