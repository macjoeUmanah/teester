<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use League\Csv\Writer;
use App\Models\Contact;
use Helper;

class ListVerify implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $list_ids, $verifier_id, $user_id;
  public $tries = 3;
  
  public function __construct($list_ids, $verifier_id, $user_id)
  {
    $this->list_ids = $list_ids;
    $this->verifier_id = $verifier_id;
    $this->user_id = $user_id;
  }

  public function handle()
  {
    $verifier = \App\Models\EmailVerifier::whereId($this->verifier_id)->first();
    $data_verifier = json_decode($verifier->attributes, true);
    $data_verifier['type'] = $verifier->type;

    $path_export = str_replace('[user-id]', $this->user_id, config('mc.path_export_verify'));
    \Helper::dirCreateOrExist($path_export); // create dir if not exist

    $file = $path_export.\Helper::uniqueID().'.csv';
    $writer = Writer::createFromPath($file, 'w+'); // create a .csv file to write data

    $file_header = [
      __('app.contact_email'),
      __('app.verified'),
      __('app.reason'),
    ];

    $writer->insertOne($file_header); // write file header

    foreach($this->list_ids as $list_id) {
      Contact::whereListId($list_id)
        ->where('verified', 'No')
        ->select('email')
        ->chunk(1000, function ($contacts)  use ($writer, $data_verifier, $verifier) {

          foreach($contacts as $contact) {
            $data_verifier['email'] = $contact->email;
            $response = Helper::verifyEmail($data_verifier, $encrypt=true);
            if($response['increment']) {
              Contact::whereEmail($contact->email)->update(['verified' => 'Yes']);
              $verifier->increment('total_verified');
            }

            $verified = $response['success'] ? 'Yes' : 'No';
            $export_data = [
              $contact->email,
              $verified,
              $response['message']
            ];

            // Write verified info
            $writer->insertOne($export_data);
          }
      });
    }

    // save notification for user to inform and download
    $notification_name = __('app.email_verifiers'). " ({$verifier->name}) "  . __('app.msg_export_successfully');
    $attributes = [
      'file' => $file
    ];
    $notification_attributes = json_encode($attributes);
    $notification = [
      'name' => $notification_name,
      'type' => 'export',
      'attributes' => $notification_attributes,
      'app_id' => $verifier->app_id,
      'user_id' => $this->user_id
    ];
    \App\Models\Notification::create($notification);

  }
}
