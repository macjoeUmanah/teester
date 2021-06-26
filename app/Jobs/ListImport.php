<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use League\Csv\Reader;
use League\Csv\Writer;
use App\Models\Contact;
use App\Models\Import;
use Helper;
use DB;

class ListImport implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $id, $user_id;
  public $tries = 3;
  public function __construct($id, $user_id)
  {
    $this->id = $id;
    $this->user_id = $user_id;
  }

  public function handle()
  {
    //$contact_import = Import::findOrFail($this->id);
    $contact_import = Import::whereId($this->id)->whereProcessed(0)->first();
    if(!$contact_import) exit;
    
    $attributes = json_decode($contact_import->attributes);

    $input['user_id'] = $this->user_id;
    $input['source'] = 'import';
    $custom_fields = $attributes->custom_fields;
    // find email key value
    $email_key = array_search('email', $custom_fields);
    // get file headers
    array_forget($custom_fields, $email_key);
    $list = \App\Models\Lists::findOrFail($attributes->list_id);
    $list_custom_fields = $list->getCustomFieldId()->toArray();

    // Get total records
    $total_records = Helper::getCsvCount($contact_import->file);

    $reader = Reader::createFromPath($contact_import->file, 'r');
    //$reader->setHeaderOffset(0);
    $records = $reader->getRecords();


    $path_export_list_stat = str_replace('[user-id]', $input['user_id'], config('mc.path_import_list'));
    Helper::dirCreateOrExist($path_export_list_stat); // create dir if not exist
    $file_export_list_stat = $path_export_list_stat.Helper::uniqueID().'.csv';
    $writer = Writer::createFromPath($file_export_list_stat, 'w+'); // create a .csv file to write data
    $file_header = [
      __('app.contact_email'),
      __('app.detail'),
    ];
    $writer->insertOne($file_header); // write file header

    $processed = 0;
    foreach ($records as $offset => $record) {
      $detail = null;
      $processed++;
      $input['email'] = $record[$email_key]; // get real email 
      $input['list_id'] = $attributes->list_id;
      $input['format'] = $attributes->format;
      $input['active'] = $attributes->active;
      $input['unsubscribed'] = $attributes->unsubscribed;
      $input['confirmed'] = $attributes->confirmed;
      $input['app_id'] = $list->app_id;
      $do_insert = true;
      if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        // Increment in invalids
        Import::whereId($this->id)->increment('invalids');
        $do_insert = false;
        $detail = 'Invalid';
      } elseif(Contact::whereEmail($input['email'])->whereListId($input['list_id'])->exists()) {
        $do_insert = false;
        $detail = 'Duplicate - Skip';
        if($attributes->duplicates == 'overwrite') {
          Contact::whereEmail($input['email'])->whereListId($input['list_id'])->forceDelete();
          $do_insert = true;
          $detail = 'Duplicate - Overwrite';
        }
        // Increment in duplicates
        Import::whereId($this->id)->increment('duplicates');
      } elseif($attributes->bounced == 'not_allowed') {
        $is_bounced = DB::table('schedule_campaign_stat_log_bounces')
              ->whereEmail($input['email'])
              ->exists();
        if($is_bounced) {
          // Increment in bounced
          Import::whereId($this->id)->increment('bounced');
          $do_insert = false;
          $detail = __('app.bounced');
        }
      } elseif($attributes->suppressed == 'not_allowed') {
        if(Helper::isSuppressed($input['email'], $contact_import->app_id)) {
          // Increment in suppressed
          Import::whereId($this->id)->increment('suppressed');
          $do_insert = false;
          $detail = __('app.suppressed');
        }
      }

      if($do_insert) {
        try {
          $contact = Contact::create($input);
          array_forget($record, $email_key);
        } catch(Exception $e) {}

        foreach($list_custom_fields as $list_custom_field) {
          $key = array_search($list_custom_field, $custom_fields);
          // If condition creating the issue if custom field in first column instead email due to 0 index
         // if(!empty($key)) {
          // need to insert null values for custom fields will help in segmentation
            $data = !empty($record[$key]) ? $record[$key] : null;
            try{
              DB::table('custom_field_contact')->insert([
                'contact_id' => $contact->id,
                'custom_field_id' => $list_custom_field,
                'data' => $data
              ]);
            } catch(\Exception $e) {
              //echo $e->getMessage();
            }
        //  }
        }
        $detail = !empty($detail) ? $detail : 'Import';
      }

      Import::whereId($this->id)->increment('processed');

      $list_import_stat_data = [
        $input['email'],
        $detail
      ];
      $writer->insertOne($list_import_stat_data); // write contact info

      // In any case if import try to exceed from the limit, may be blank addresses
      if($processed == $total_records) break;

      if($do_insert) {
        // if client have limit to import the contacts
        if(!Helper::allowedLimit($list->app_id, 'no_of_recipients', 'contacts')) {
          $notification_name = __('app.msg_limit_over') . __('app.contacts');
          break;
        }
      }
    }

    // save notification
    $notification_name = !empty($notification_name) ? $notification_name : $list->name . __('app.msg_import_successfully');
    $attributes = [
      'file' => $file_export_list_stat
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

    // unlink list tmp file after import
    try {
     unlink($contact_import->file);
    } catch(\Exception $e) {
      \Log::error("job:list-import => ".$e->getMessage());
    }
  }
}
