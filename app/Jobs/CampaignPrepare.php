<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use League\Csv\Writer;
use App\Models\ScheduleCampaign;
use DB;
use Helper;

class CampaignPrepare implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  private $processed = 0;
  private $inactive =  0;
  private $unsubscribed = 0;
  private $suppressed = 0;
  private $bounced = 0;
  private $spammed = 0;
  private $duplicates = 0;
  private $batch_no = 0;
  private $i = 0;
  private $batch_size = 5000;
  private $old_email = null;
  private $writer = null;
  protected $schedule_campaign_id;
  public $tries = 5;

  public function __construct($id)
  {
    $this->schedule_campaign_id = $id;
  }

  public function handle()
  {
    //$schedule = ScheduleCampaign::findOrFail($this->schedule_campaign_id);
    $schedule = ScheduleCampaign::whereId($this->schedule_campaign_id)->whereScheduled(0)->first();
    if(!$schedule) exit;

    if(json_decode($schedule->sending_speed)->speed == 'limited') {
      $email_per_batch = json_decode($schedule->sending_speed)->limit;
    } else {
      $email_per_batch = $this->batch_size;
    }

    $path_schedule_campaign = str_replace('[user-id]', $schedule->user_id, config('mc.path_schedule_campaign'));
    $path_schedule_campaign .= $this->schedule_campaign_id;

    $broadcast = DB::table('broadcasts')->whereId($schedule->broadcast_id)->first();

    $list_ids = explode(',', $schedule->list_ids);

    // without distinct
    $total = DB::table('contacts')->whereIn('list_id', $list_ids)->count();

    ScheduleCampaign::whereId($this->schedule_campaign_id)->update([
      'total' => $total
    ]);

    // if alread exist, it normally happanes for large campaing
    if(!\App\Models\ScheduleCampaignStat::whereScheduleCampaignId($schedule->id)->exists()) {
      // Create record for schedule_campaing_stats table also
      $schedule_by = \App\Models\User::getUserValue($schedule->user_id, 'name');
      $stat_data = [
        'schedule_campaign_id'   => $schedule->id,
        'schedule_campaign_name' => $schedule->name,
        'schedule_by'      => $schedule_by,
        'threads'          => $schedule->threads,
        'total'            => $total,
        'scheduled'        => 0,
        'sent'             => 0,
        'start_datetime'   => $schedule->send_datetime,
        'sending_speed'    => $schedule->sending_speed,
        'app_id'           => $schedule->app_id,
        'user_id'          => $schedule->user_id,
      ];
      $schedule_stat = \App\Models\ScheduleCampaignStat::create($stat_data);

      \App\Models\Contact::whereIn('list_id', $list_ids)
        ->with('list')
        ->with('customFields')
        ->orderBy('email')
        ->orderBy('id')
        ->chunk($this->batch_size, function ($contacts) use ($email_per_batch, $path_schedule_campaign, $broadcast, $schedule) {

          foreach ($contacts as $contact) {
            // Check inactive
            if($contact->active == 'No') { $this->inactive++; continue; }

            // Check unsubscribed
            if($contact->unsubscribed == 'Yes') { $this->unsubscribed++; continue; }

            // Check suppressed
            if(Helper::isSuppressed($contact->email, $schedule->app_id, $contact->list_id)) { $this->suppressed++; continue; }

            // Skip duplicates; group by clause mantain same emails consecutives
            if($contact->email == $this->old_email) { $this->duplicates++; continue; }

            $this->old_email = $contact->email; // Keep old email record to compare next time 

            // Check bounced
            $is_bounced = DB::table('schedule_campaign_stat_log_bounces')
              ->whereEmail($contact->email)
              ->exists();
            if($is_bounced)  { $this->bounced++; continue; }

            // Check spammed
            $is_spammed = DB::table('schedule_campaign_stat_log_spams')
              ->whereEmail($contact->email)
              ->exists();
            if($is_spammed)  { $this->spammed++; continue; }

            if($this->batch_no == 0 || $this->i >= $email_per_batch) {
              // Need to start file with 1
              $this->batch_no++;
              Helper::dirCreateOrExist($path_schedule_campaign); //Create dir if not exist
              $file = $path_schedule_campaign.DIRECTORY_SEPARATOR.$this->batch_no.'.csv';
              // 5 sec break;
              sleep(5);

              // Sometime it restart to write the file so handel it
              if(file_exists($file)) exit;

              $this->writer = Writer::createFromPath($file, 'w+'); // Create a .csv file to write data
              //chmod($file, 0777);  // File Permission
              $data = [
                'ID', 
                'EMAIL',
                'FORMAT',
                'LIST',
                'BROADCAST_ID',
                'BROADCAST_NAME',
                'EMAIL_SUBJECT',
                'BROADCAST',
              ];
              $this->writer->insertOne($data); // Write data into file
              $this->i = 0;

              // Need to start campaign when 1 file ready to send
              if($this->batch_no > 1) {
                ScheduleCampaign::whereId($this->schedule_campaign_id)->update([
                  'total_threads' => $this->batch_no
                ]);

                // Only need to make schedule for when 1st complete
                if($this->batch_no == 2) {
                  ScheduleCampaign::whereId($this->schedule_campaign_id)->update([
                    'status' => 'Scheduled'
                  ]);
                }
              }
              
            }

            $broadcast_content = ($contact->format == 'HTML') ? $broadcast->content_html : $broadcast->content_text;

            // Replace spintags
            $broadcast_content = Helper::replaceSpintags(Helper::decodeString($broadcast_content));
            $email_subject = Helper::replaceSpintags(Helper::decodeString($broadcast->email_subject));

            // Replace custom field
            $broadcast_content = Helper::replaceCustomFields($broadcast_content, $contact->customFields);
            $email_subject = Helper::replaceCustomFields($email_subject, $contact->customFields);

            $data = [
              $contact->id,
              $contact->email,
              $contact->format,
              Helper::decodeString($contact->list->name),
              $broadcast->id,
              Helper::decodeString($broadcast->name),
              $email_subject,
              $broadcast_content
            ];
            $this->writer->insertOne($data); // Write data into file
            $this->i++;
            $this->processed++;

            // Campaing status checks on while sending campaing 
            $schedule->increment('scheduled');
          }
        });

        $scheduled_detail = [
          'Total'        => $total,
          'Scheduled'    => $this->processed,
          'Inactive'     => $this->inactive,
          'Unsubscribed' => $this->unsubscribed,
          'Duplicates'   => $this->duplicates,
          'Suppressed'   => $this->suppressed,
          'Bounced'      => $this->bounced,
          'Spammed'      => $this->spammed,
        ];

        // If there is only 1 batch then upper condtion will not execute
        if($this->batch_no == 1) {
          ScheduleCampaign::whereId($this->schedule_campaign_id)->update([
            'status' => 'Scheduled'
          ]);
        }

        // Update schedule_campaigns table 
        ScheduleCampaign::whereId($this->schedule_campaign_id)->update([
          'scheduled' => $this->processed,
          'total_threads'   => $this->batch_no,
          'scheduled_detail' => json_encode($scheduled_detail),
        ]);



        // Update schedule_campaigns table 
        \App\Models\ScheduleCampaignStat::whereId($schedule_stat->id)->update([
          'scheduled_detail' => json_encode($scheduled_detail),
          'scheduled'        => $this->processed,
        ]);
      }

  }
}
