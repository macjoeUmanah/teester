<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use League\Csv\Writer;
use Helper;

class BounceExport implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $app_id, $user_id;
  public $tries = 3;

  public function __construct($app_id, $user_id)
  {
    $this->app_id = $app_id;
    $this->user_id = $user_id;
  }

  public function handle()
  {
    $path_export_blacklist = str_replace('[user-id]', $this->user_id, config('mc.path_export_blacklist'));
    \Helper::dirCreateOrExist($path_export_blacklist); // create dir if not exist

    $file = $path_export_blacklist. 'bounces-'.Helper::uniqueID().'.csv';
    $writer = Writer::createFromPath($file, 'w+'); // create a .csv file to write data

    $file_header = [
      __('app.email'),
      __('app.type'),
      __('app.code'),
      __('app.detail'),
      __('app.datetime'),
    ];

    $writer->insertOne($file_header); // write file header

    \App\Models\ScheduleCampaignStatLogBounce::whereNotNull('id')
     ->chunk(1000, function ($bounces)  use ($writer) {
        $time_zone = \App\Models\User::getUserValue($this->user_id, 'time_zone');
        foreach($bounces as $bounce) {
          $bounce_data = [
            $bounce->email,
            $bounce->type,
            $bounce->code,
            json_decode($bounce->detail)->short_detail,
            Helper::datetimeDisplay($bounce->created_at, $time_zone),
          ];

          $writer->insertOne($bounce_data); // write contact info
        }
     });

     // save notification for user to inform and download
    $notification_name = __('app.global_bounced') .' ' . __('app.msg_export_successfully');
    $attributes = [
      'file' => $file
    ];
    $notification_attributes = json_encode($attributes);
    $notification = [
      'name' => $notification_name,
      'type' => 'export',
      'attributes' => $notification_attributes,
      'app_id' => $this->app_id,
      'user_id' => $this->user_id
    ];
    \App\Models\Notification::create($notification);
  }
}
