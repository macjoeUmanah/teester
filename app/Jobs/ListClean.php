<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Contact;
use League\Csv\Writer;
use Helper;
use DB;

class ListClean implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $list_id, $user_id, $options;
    public $tries = 3;

    public function __construct($id, $user_id, $options)
    {
      $this->list_id = $id;
      $this->user_id = $user_id;
      $this->options = $options;
    }

    public function handle()
    {
      $list_contacts = Contact::whereListId($this->list_id);

      $path_export = str_replace('[user-id]', $this->user_id, config('mc.path_downloads'));
      Helper::dirCreateOrExist($path_export); // create dir if not exist

      $file = $path_export.\Helper::uniqueID().'.csv';
      $writer = Writer::createFromPath($file, 'w+'); // create a .csv file to write data

      $file_header = [
        __('app.contact_email'),
        __('app.option'),
        __('app.action'),
      ];

      $list_contacts = $list_contacts->chunk(1000, function ($contacts) use ($writer) {
        foreach($contacts as $contact) {

          // Check unsubscribed
          if(in_array('unsubscribed', $this->options) && $contact->unsubscribed == 'Yes') {
            $contact::destroy($contact->id);
            $clean_data = [
              $contact->email,
              __('app.unsubscribed'),
              __('app.removed')
            ];
            // Write verified info
            $writer->insertOne($clean_data);
            continue;
          }

          // Check inactive
          if(in_array('inactive', $this->options) && $contact->active == 'No') {
            $contact::destroy($contact->id);
            $clean_data = [
              $contact->email,
              __('app.inactive'),
              __('app.removed')
            ];
            // Write verified info
            $writer->insertOne($clean_data);
            continue;
          }

          // Check unconfirmed
          if(in_array('not_confirmed', $this->options) && $contact->confirmed == 'No') {
            $contact::destroy($contact->id);
            $clean_data = [
              $contact->email,
              __('app.unconfirmed'),
              __('app.removed')
            ];
            // Write verified info
            $writer->insertOne($clean_data);
            continue;
          }

          // Check inactive
          if(in_array('unverified', $this->options) && $contact->verified == 'No') {
            $contact::destroy($contact->id);
            $clean_data = [
              $contact->email,
              __('app.unverified'),
              __('app.removed')
            ];
            // Write verified info
            $writer->insertOne($clean_data);
            continue;
          }

          // Check suppressed
          if(in_array('suppressed', $this->options) && Helper::isSuppressed($contact->email, $contact->app_id, $contact->list_id)) {
            $contact::destroy($contact->id);
            $clean_data = [
              $contact->email,
              __('app.suppressed'),
              __('app.removed')
            ];
            // Write verified info
            $writer->insertOne($clean_data);
            continue;
          }

          if(in_array('bounced', $this->options)) {
            // Check bounced
            $is_bounced = DB::table('schedule_campaign_stat_log_bounces')
              ->whereEmail($contact->email)
              ->exists();
            if($is_bounced) {
              $contact::destroy($contact->id);
              $clean_data = [
                $contact->email,
                __('app.bounced'),
                __('app.removed')
              ];
              // Write verified info
              $writer->insertOne($clean_data);
              continue;
            }
          }

          if(in_array('spam', $this->options)) {
            // Check spammed
            $is_spammed = DB::table('schedule_campaign_stat_log_spams')
              ->whereEmail($contact->email)
              ->exists();
            if($is_spammed) {
              $contact::destroy($contact->id);
              $clean_data = [
                $contact->email,
                __('app.spam'),
                __('app.removed')
              ];
              // Write verified info
              $writer->insertOne($clean_data);
              continue;
            }
          }
        }
      });

      $list = \App\Models\Lists::whereId($this->list_id)->first();
      // save notification for user to inform and download
      $notification_name = __('app.email_clean'). " ({$list->name}) "  . __('app.msg_list_clean_successfully');
      $attributes = [
        'file' => $file
      ];
      $notification_attributes = json_encode($attributes);
      $notification = [
        'name' => $notification_name,
        'type' => 'export',
        'attributes' => $notification_attributes,
        'app_id' => $list->app_id,
        'user_id' => $this->user_id
      ];
      \App\Models\Notification::create($notification);
      }
}
