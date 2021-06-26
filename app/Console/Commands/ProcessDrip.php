<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduleDrip;
use App\Models\ScheduleDripStatLog;
use App\Models\SendingServer;
use App\Models\Drip;
use Helper;
use DB;

class ProcessDrip extends Command
{
  protected $signature = 'mc:process-drip';
  protected $description = 'Process drips that have been scheduleds';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Only need to fetch one drip other cron will entertain next drip if exist
    $schedule_drips = ScheduleDrip::whereInProgress(false)
      ->whereStatus('Running')
      ->get();
    foreach($schedule_drips as $schedule_drip) {
      if(!empty($schedule_drip)) {
        // Next cron will not enterin this drip schedulep until finish
        ScheduleDrip::whereId($schedule_drip->id)->update(['in_progress' => true]);

        $trigger = \App\Models\Trigger::whereId($schedule_drip->trigger_id)->first();

        $lists = \App\Models\Lists::whereIn('id', explode(',', $schedule_drip->list_ids))->get();

        foreach($lists as $list) {
          $contact_result = \App\Models\Contact::whereListId($list->id)
            ->whereActive('Yes')
            ->whereUnsubscribed('No');

          if($schedule_drip->send_to_existing == 'No') {
            //$contact_result->whereCreatedAt($schedule_drip->created_at);
            $contact_result->where('created_at', '>', $schedule_drip->created_at);
          }

            $contact_result->chunk(1000, function($contacts) use ($schedule_drip, $list, $trigger) {

              $drips = Drip::whereGroupId($schedule_drip->drip_group_id)
                ->whereActive('Yes')
                ->orderBy('after_minutes', 'ASC')
                ->get();

              // Get schedle drip stat
              $schedule_drip_stat = \App\Models\ScheduleDripStat::whereScheduleDripId($schedule_drip->id)->first();

              // settings
              $settings = DB::table('settings')->whereId(config('mc.app_id'))->first();
              $tracking = $settings->tracking == 'enabled' ? true : false;
              $app_url = $settings->app_url;


              $sending_speed = json_decode($trigger->attributes)->sending_speed;
              if(!empty($sending_speed) && $sending_speed == 'limited') {
                $sending_limit = json_decode($trigger->attributes)->sending_limit;
                $wait = floor(3600 / $sending_limit); // divide on 1 hour
              } else {
                $wait = false;
              }
              // Pick sending server id
              $sending_server_ids = json_decode($trigger->sending_server_ids);
              // Retrun array of sending servers
              $sending_servers = SendingServer::getActiveSeningServers($sending_server_ids, 'array');

              // If no sending server then no need to do anything
              if(empty($sending_servers)) {
                $this->setScheduleStatus($schedule->id, 'System Paused');
              }

              // Will be use to reset the sending_server array when  all picked
              $sending_servers_data = $sending_servers;

              $carbon = new \Carbon\Carbon();
              foreach($contacts as $contact) {
                foreach($drips as $drip) {

                  // Check if drip is paused
                  $drip_status = ScheduleDrip::whereId($schedule_drip->id)->value('status');
                  if($drip_status == 'Paused') exit;

                  // If already sent a drip on a contact
                  if(ScheduleDripStatLog::whereDripId($drip->id)->whereScheduleDripStatId($schedule_drip->id)->whereEmail($contact->email)->exists()) continue;

                  // If bounced
                  if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) continue;

                  // Get broadcast
                  $broadcast = \App\Models\Broadcast::whereId($drip->broadcast_id)->first();

                  // Get drip time
                  $drip_stat_log_contact = ScheduleDripStatLog::select('created_at')->whereScheduleDripStatId($schedule_drip->id)->whereEmail($contact->email)->orderBy('id', 'Desc')->first();
                  if(!empty($drip_stat_log_contact)) {
                    $drip_time = $carbon->parse($drip_stat_log_contact->created_at)->addMinutes($drip->after_minutes);
                  } else {
                    $drip_time = $carbon->parse($contact->created_at)->addMinutes($drip->after_minutes);
                  }
                  

                  // Send email
                  if($drip_time <= \Carbon\Carbon::now()) {

                    // get sending server
                    $sending_server = array_shift($sending_servers);

                    // Sending servers info that assigned previously to reset the sending servers when all picked
                    if(empty($sending_servers)) {
                      $sending_servers = $sending_servers_data;
                      $sending_server = array_shift($sending_servers);
                    }

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
                      $content = Helper::replaceSpintags(Helper::decodeString($broadcast->content_html));
                      $email_subject = Helper::replaceSpintags(Helper::decodeString($broadcast->email_subject));

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

                      // Create ScheduleDripStatLog and the id would be use to track the email
                      $schedule_drip_stat_log_data = [
                        'schedule_drip_stat_id' => $schedule_drip_stat->id,
                        'drip_id' => $drip->id,
                        'drip_name' => $drip->name,
                        'message_id' => $message_id,
                        'email' => $contact->email,
                        'list' => $list->name,
                        'broadcast' => $broadcast->name,
                        'sending_server' => $sending_server['name'],
                      ];

                      $schedule_drip_stat_log = ScheduleDripStatLog::create($schedule_drip_stat_log_data);

                      if($tracking) {

                        // click tracking should be before track_opens becuase don't want to convert that url
                        $content = Helper::convertLinksForClickTracking($schedule_drip_stat_log->id, $tracking_domain, $content, $app_url, '/d/click/');

                        // Make open tracking url and pixel d=drip
                        $track_open = $tracking_domain.'/d/open/'.base64_encode($schedule_drip_stat_log->id);
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
                          $headers->addTextHeader('MC-Type-ID', "drip-{$schedule_drip_stat_log->id}-{$drip->app_id}");

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
                            $headers->addTextHeader('x-job', "drip-{$schedule_drip_stat_log->id}-{$drip->app_id}");
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

                          $load_sending_servers = false;
                          try {
                            $connection['transport']->send($message);
                            $status = 'Sent';
                          } catch(\Exception $e) {
                            \Log::error('mc:process-drip => '.$e->getMessage());
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
                            \Log::error('mc:process-drip => '.$e->getMessage());
                            $status = 'Failed';
                          }
                        }

                        // Should be check in both case
                        //if($status == 'Sent') {
                          $sending_server_data = Helper::updateSendingServerCounters($sending_server['id']);
                        //}

                          if($sending_server_data['sending_server_paused']) {
                            $load_sending_servers = true;
                          }

                        // Update status
                        ScheduleDripStatLog::whereId($schedule_drip_stat_log->id)->update(['status' => $status]);

                        if($wait) sleep($wait);
                    } else {
                      // If sending server connection failed then need to update it as system inactive
                      // Removing single and double quote due to output issue with js alert at frontend 
                      SendingServer::whereId($sending_server['id'])->update(['status' => 'System Inactive', 'notification' => str_replace( ["'",'"'], '', explode('.',$connection['msg'])[0] )]);

                      $load_sending_servers = true;
                    }

                    if($load_sending_servers) {
                      // Retrun new array of sending servers after make a sending server as system inactive
                      $sending_servers_data = SendingServer::getActiveSeningServers($sending_server_ids, 'array');

                      // If no sending server then no need to do anything
                      if(empty($sending_servers_data)) {
                        exit;
                      }
                    }

                    // Must exit from drip loop, mail already send to last possible drip;
                    break;
                  }
                }
              }
            });
        }
        // Next cron should enterin this drip schedule now
        ScheduleDrip::whereId($schedule_drip->id)->update(['in_progress' => false]);
      }
    }
  }
}
