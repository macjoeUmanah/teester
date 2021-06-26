<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use League\Csv\Writer;

class ListExport implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $list_id, $user_id, $field;
  public $tries = 3;
  
  public function __construct($id, $user_id, $field)
  {
    $this->list_id = $id;
    $this->user_id = $user_id;
    $this->field = $field;
  }

  public function handle()
  {
    $list = \App\Models\Lists::findOrFail($this->list_id);
    $path_export_list = str_replace('[user-id]', $this->user_id, config('mc.path_export_list'));
    \Helper::dirCreateOrExist($path_export_list); // create dir if not exist

    $file = $path_export_list.str_slug($list->name).'-'.\Helper::uniqueID().'.csv';
    $writer = Writer::createFromPath($file, 'w+'); // create a .csv file to write data

    // create file header
    $list_custom_fields = $list->customFields()->orderBy('id')->pluck('name');

    $file_header = [
      __('app.contact_email'),
      __('app.format'),
      __('app.active'),
      __('app.confirmed'),
      __('app.verified'),
      __('app.unsubscribed'),
    ];
    foreach($list_custom_fields as $custom_field) {
      array_push($file_header, $custom_field);
    }

    $writer->insertOne($file_header); // write file header

    $list_contacts = \App\Models\Contact::whereListId($this->list_id)
      ->with('customFields');

    if(stripos($this->field, 'options_') === false) {
      if($this->field == 'active') {
        $list_contacts->whereActive('Yes');
      } elseif($this->field == 'inactive') {
        $list_contacts->whereActive('No');
      } elseif($this->field == 'confirmed') {
        $list_contacts->whereConfirmed('Yes');
      } elseif($this->field == 'notconfirmed') {
        $list_contacts->whereConfirmed('No');
      } elseif($this->field == 'verified') {
        $list_contacts->whereVerified('Yes');
      } elseif($this->field == 'notverified') {
        $list_contacts->whereVerified('No');
      } elseif($this->field == 'unsubscribed') {
        $list_contacts->whereUnsubscribed('Yes');
      } elseif($this->field == 'notunsubscribed') {
        $list_contacts->whereUnsubscribed('No');
      }
    } else {
      $fields = explode('_', $this->field);
      foreach($fields as $field) {
        if($field == 'active') {
          $list_contacts->whereActive('Yes');
        } elseif($field == 'inactive') {
          $list_contacts->whereActive('No');
        } elseif($field == 'confirmed') {
          $list_contacts->whereConfirmed('Yes');
        } elseif($field == 'notconfirmed') {
          $list_contacts->whereConfirmed('No');
        } elseif($field == 'verified') {
          $list_contacts->whereVerified('Yes');
        } elseif($field == 'notverified') {
          $list_contacts->whereVerified('No');
        } elseif($field == 'unsubscribed') {
          $list_contacts->whereUnsubscribed('Yes');
        } elseif($field == 'notunsubscribed') {
          $list_contacts->whereUnsubscribed('No');
        }
      }
    }

    print_r($fields);

    $list_contacts = $list_contacts->chunk(1000, function ($contacts)  use ($writer) {
        foreach($contacts as $contact) {
          $contact_data = [
            $contact->email,
            $contact->format,
            $contact->active,
            $contact->confirmed,
            $contact->verified,
            $contact->unsubscribed,
          ];

          $custom_fields = $contact->customFields()->orderBy('id')->get();
          if(!empty($custom_fields)) {
            foreach($custom_fields as $custom_field) {
              $custom_field_data = str_replace('||', ', ', $custom_field->pivot->data);
              array_push($contact_data, $custom_field_data);
            }
          }

          $writer->insertOne($contact_data); // write contact info
        }
    });

    // save notification for user to inform and download
    $notification_name = __('app.list'). " ({$list->name}) "  . __('app.msg_export_successfully');
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
