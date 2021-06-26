<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trigger;
use App\Models\TriggerSchedule;
use App\Models\Contact;
use App\Models\Lists;
use DB;

class ProcessTrigger extends Command
{
  protected $signature = 'mc:process-trigger';
  protected $description = 'Process triggers that have been set';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // First need to delete or inactive the drips for Inactive triggers others email will be send to those
    $this->inActiveTriggers();

    // Get active triggres and with execution_datetime
    $triggers = Trigger::whereActive('Yes')
      ->where('execution_datetime', '<=', \Carbon\Carbon::now())
      ->get();

    if(!empty($triggers)) {
      foreach($triggers as $trigger) {
        $trigger_attributes = json_decode($trigger->attributes);

        //print_r($trigger_attributes);
        if($trigger->based_on == 'list') {
          /*
          If trigger action is start drip then only need to insert data into schedule drip
          rest of the functionality will remain same and send emails via ProressTrigger
          */
          if($trigger->action == 'start_drip') {
            if(!\App\Models\ScheduleDrip::whereTriggerId($trigger->id)->exists()) {
              // Save schedule drip data
              $drip = $this->saveScheduleDrip($trigger);
              // Need to save data for drip stat also
              $this->saveDripStat($drip);
            } else {
              \App\Models\ScheduleDrip::whereTriggerId($trigger->id)->update(['status' => 'running']);
            }
            continue;
          }

          $contacts = Contact::whereIn('list_id', $trigger_attributes->list_ids);

          // get Contact datetime for condition either send for pervious for new
          $contact_datetime_marker = $this->getContactDatetimeMarker($trigger);
          // What contacts need to be get
          $contacts = $contacts->where('created_at', '>=', $contact_datetime_marker);

          $contacts = $contacts->whereActive('Yes')
            ->whereUnsubscribed('No')
            ->orderBy('email')
            ->orderBy('id')
            ->chunk(1000, function ($contacts) use ($trigger) {
              $trigger_attributes = json_decode($trigger->attributes);
              foreach ($contacts as $contact) {
                // If bounced
                if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) continue;

                $contact_send_datetime = $this->ContactSendDatetime($trigger_attributes, $contact->created_at);

                // Save trigger log data
                $this->SaveTriggerLog($trigger_attributes, $trigger, $contact->id, $contact_send_datetime);
              }
            });
        } elseif($trigger->based_on == 'segment') {
          try {
            // get segment
            $segment = \App\Models\Segment::whereId($trigger_attributes->segment_id)->first();
            $segment_type = $segment->type;
            if($segment_type == 'List') {
              $query = \App\Models\Segment::querySegmentList($segment->attributes);
              $query->orderBy('id', 'DESC')->distinct();
            } elseif($segment_type == 'Campaign') {
              $query = \App\Models\Segment::querySegmentCampaign($segment->attributes, $segment->user_id);
              $query->orderBy('schedule_campaign_stat_logs.id', 'DESC')->distinct();
            }

          } catch(\Exception $e) {
            \Log::error('mc:process-trigger => '.$e->getMessage());
          }

          $contact_datetime_marker = $this->getContactDatetimeMarker($trigger);

          if($segment_type == 'List') {
            // What contacts need to be get
            $query = $query->whereActive('Yes')->whereUnsubscribed('No')->where('created_at', '>=', $contact_datetime_marker);
          }

          // Get segmented data with 1000 limit
          $query->chunk(1000, function($contacts) use ($trigger, $segment_type, $contact_datetime_marker) {
            $trigger_attributes = json_decode($trigger->attributes);
            foreach($contacts as $contact) {
              // If bounced
              if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) continue;

              $contact_send_datetime = $this->ContactSendDatetime($trigger_attributes, $contact->created_at);

              // We did not added the contact query about send datetime for campaing so need to check here
              if($segment_type == 'Campaign') {
                // $contact is basically schedule_campaign_stat_logs in campaign case
                // get Contact Id with list id
                $list_id = Lists::whereName(trim($contact->list))->value('id');
                $contact_id = Contact::whereEmail(trim($contact->email))->whereListId($list_id)->value('id');
                //if(Contact::whereActive('Yes')->whereUnsubscribed('No')->where('created_at', '>=', $contact_datetime_marker)->exists()){
                  $this->SaveTriggerLog($trigger_attributes, $trigger, $contact_id,  $contact_send_datetime);
               // }
              } else {
                // else if segment_type == list, already query has been filtered
                $this->SaveTriggerLog($trigger_attributes, $trigger, $contact->id, $contact_send_datetime);
              }
            }
          });
        } elseif($trigger->based_on == 'date') {
          // get trigger send datetime in db format
          $trigger_datetime = $trigger_attributes->send_date .' '. date("H:m:s", strtotime($trigger_attributes->send_time));

          // run only when datetime is 
          if(strtotime($trigger_datetime) < strtotime(\Carbon\Carbon::now())) {
            /*
            If trigger action is start drip then only need to insert data into schedule drip
            rest of the functionality will remain same and send emails via ProressTrigger
            */
            if($trigger->action == 'start_drip') {
              if(!\App\Models\ScheduleDrip::whereTriggerId($trigger->id)->exists()) {
                // Save schedule drip data
                $drip = $this->saveScheduleDrip($trigger);
                // Need to save data for drip stat also
                $this->saveDripStat($drip);
              } else {
                \App\Models\ScheduleDrip::whereTriggerId($trigger->id)->update(['status' => 'running']);
              }
              continue;
            }

            $contacts = Contact::whereIn('list_id', $trigger_attributes->list_ids);
            // get Contact datetime for condition either send for pervious for new
            $contact_datetime_marker = $this->getContactDatetimeMarker($trigger);
            // What contacts need to be get
            $contacts = $contacts->where('created_at', '>=', $contact_datetime_marker);
            $contacts = $contacts->whereActive('Yes')
              ->whereUnsubscribed('No')
              ->orderBy('email')
              ->orderBy('id')
              ->chunk(1000, function ($contacts) use ($trigger) {
                $trigger_attributes = json_decode($trigger->attributes);
                foreach ($contacts as $contact) {
                   // If bounced
                  if(DB::table('schedule_campaign_stat_log_bounces')->whereEmail($contact->email)->exists()) continue;

                  $contact_send_datetime = $this->ContactSendDatetime($trigger_attributes, $contact->created_at);

                  // Save trigger log data
                  $this->SaveTriggerLog($trigger_attributes, $trigger, $contact->id, $contact_send_datetime);

                }
              });
          }
        }
      } // end foreach triggers
    } // end if no trigger
  }

  private function getContactDatetimeMarker($trigger) {
    $trigger_log = DB::table('trigger_logs')->whereTriggerId($trigger->id)->orderBy('id', 'desc')->first();

    // If no trigger data into logs
    $now = \Carbon\Carbon::now();
    if(empty($trigger_log)) {
      $trigger_log_datetime = $now;
    } else {
      $trigger_log_datetime = $trigger_log->created_at;
    }

    // Save last trigger date time
    DB::table('trigger_logs')->insert(['trigger_id' => $trigger->id, 'created_at' => $now]);

    $trigger_attributes = json_decode($trigger->attributes);
    if($trigger_attributes->based_on_action == 'only_newly_added') {
      $contact_datetime_marker = $trigger_log_datetime;
    } elseif($trigger_attributes->based_on_action == 'all_previous_newly_added') {
      // default would be for all if no entry in log
      if(empty($trigger_log)) {
        $contact_datetime_marker = '2000-01-01 00:00:00';
      } else {
        $contact_datetime_marker = $trigger_log_datetime;
      }
    }
    return $contact_datetime_marker;
  }


  // Get contact send datetime for trigger
  private function ContactSendDatetime($trigger_attributes, $contact_created_at)
  {
    $carbon = new \Carbon\Carbon();
    // If trigger is instant otherwise according to time is set
    if($trigger_attributes->trigger_start == 'instant') {
      $contact_send_datetime = $carbon->now();
    } else {
      if($trigger_attributes->trigger_start_duration == 'minutes') {
        $contact_send_datetime = $carbon->parse($contact_created_at)->addMinutes($trigger_attributes->trigger_start_limit);
      } elseif($trigger_attributes->trigger_start_duration == 'hours') {
        $contact_send_datetime = $carbon->parse($contact_created_at)->addHours($trigger_attributes->trigger_start_limit);
      } elseif($trigger_attributes->trigger_start_duration == 'days') {
        $contact_send_datetime = $carbon->parse($contact_created_at)->addDays($trigger_attributes->trigger_start_limit);
      }
    }
    return $contact_send_datetime;
  }

  /**
   * Save drip schedule
  */
  private function saveScheduleDrip($trigger)
  {
    $trigger_attributes = json_decode($trigger->attributes);
    // Pick sending server id
    $sending_servers = json_decode($trigger_attributes->sending_server_ids);
    $sending_server_id_key = array_rand($sending_servers, 1);
    $drip_schedule = [
      'name' => $trigger->name,
      'drip_group_id' => $trigger_attributes->drip_group_id,
      'list_ids' => implode(',', $trigger_attributes->list_ids),
      'sending_server_id' => $sending_servers[$sending_server_id_key] ?? null,
      'send_to_existing' => ($trigger_attributes->based_on_action == 'only_newly_added' ? 'No' : 'Yes'),
      'status' => 'running',
      'trigger_id' => $trigger->id,
      'user_id' => $trigger->user_id,
      'app_id' => $trigger->app_id
    ];
    // Save ScheduleDrip data
    $drip =  \App\Models\ScheduleDrip::create($drip_schedule);

    return $drip;
  }

  /**
  * Save data for drip stat
  */
  private function saveDripStat($drip) {
    //print_r($drip);
    $data['schedule_drip_id'] = $drip->id;
    $data['schedule_by'] = \App\Models\User::getUserValue($drip->user_id, 'name');
    $data['schedule_drip_name'] = $drip->name;
    $data['drip_group_name'] = \App\Models\Group::whereId($drip->drip_group_id)->value('name');
    $data['app_id'] = $drip->app_id;
    $data['user_id'] = $drip->user_id;

    \App\Models\ScheduleDripStat::create($data);
  }

  // Save trigger logs
  private function SaveTriggerLog($trigger_attributes, $trigger, $contact_id, $contact_send_datetime)
  {
    // Pick sending server id
    $sending_servers = json_decode($trigger_attributes->sending_server_ids);
    $sending_server_id_key = array_rand($sending_servers, 1);

    // if action is send campaign
    if($trigger->action == 'send_campaign') {
      $trigger_schedules = [
        'trigger_id' => $trigger->id,
        'contact_id' => $contact_id,
        'send_datetime' => $contact_send_datetime,
        'broadcast_id' => $trigger_attributes->broadcast_id ?? null,
        'sending_server_id' => $sending_servers[$sending_server_id_key] ?? null,
        'action' => $trigger->action
      ];
      // Save data to send email
      TriggerSchedule::create($trigger_schedules);
    }
  }

  private function inActiveTriggers()
  {
    // Get inactive triggres
    $triggers = Trigger::whereActive('No')->get();
    if(!empty($triggers)) {
      foreach($triggers as $trigger) {
        if($trigger->action == 'start_drip') {
          \App\Models\ScheduleDrip::whereTriggerId($trigger->id)->update(['status' => 'paused']);
        } else {
          // Delete data from Trigger Logs
          TriggerSchedule::whereTriggerId($trigger->id)->delete();
        }
      }
    }
  }
}

