<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fbl;
use Helper;

use Webklex\IMAP\Client;

class ProcessFbls extends Command
{
  protected $signature = 'mc:process-fbls';
  protected $description = 'Process the feed back loops';
  public $app_id = 1;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $flbs = Fbl::active()->get();
    foreach($flbs as $fbl) {
      $validate_cert = $fbl->validate_cert == 'Yes' ? true : false;
      $password = !empty($fbl->password) ? \Crypt::decrypt($fbl->password) : '';
      $oClient = new Client([
        'host'          => $fbl->host,
        'port'          => $fbl->port,
        'encryption'    => $fbl->encryption,
        'validate_cert' => $validate_cert,
        'username'      => $fbl->username,
        'password'      => $password,
        'protocol'      => $fbl->method
      ]);

      $this->app_id = $fbl->app_id;

      try {
        //Connect to the IMAP Server
        $oClient->connect();

        //Get all Mailboxes
        $aFolder = $oClient->getFolders();

        //Loop through every Mailbox
        foreach($aFolder as $oFolder){
          //Get 1 day old Messages of the current Mailbox $oFolder
          $aMessage = $oFolder->query()->since(now()->subDays(1))->get();
          foreach($aMessage as $oMessage) {
            // Get mc_type header value
            try {
              // To process only campaign bounces; mc_type can be drip etc
              $mc_type = $oMessage->getHeaderInfo()->mc_type_id;
            } catch(\Exception $e) {
              $mc_type = 'campaign';
            }

            // If campaign then needs to update schedule_campaing tables
            try {
              $stat_id = explode('-', $mc_type)[1];
            } catch(\Exception $e) {
              $stat_id = 0;
            }

            $section = 'Campaign';
            $to_email = null;
            if(stripos($mc_type, 'campaign') !== false) {
              \App\Models\ScheduleCampaignStatLog::whereId($stat_id)->update(['status' => 'Spammed']);
              $to_email = \App\Models\ScheduleCampaignStatLog::whereId($stat_id)->value('email');
            } if(stripos($mc_type, 'drip') !== false) {
              \App\Models\ScheduleDripStatLog::whereId($stat_id)->update(['status' => 'Spammed']);
              $to_email = \App\Models\ScheduleDripStatLog::whereId($stat_id)->value('email');
              $section = 'Drip';
            } if(stripos($mc_type, 'autofollowup') !== false) {
              \App\Models\AutoFollowupStatLog::whereId($stat_id)->update(['status' => 'Spammed']);
              $to_email = \App\Models\AutoFollowupStatLog::whereId($stat_id)->value('email');
              $section = 'AutoFollowup';
            }

            $full_detail = !empty($oMessage->getTextBody()) ? $oMessage->getTextBody() : $oMessage->getHTMLBody(true);

            Helper::saveSpam($to_email, $stat_id, $section, $full_detail, $this->app_id);
          }

          if($fbl->delete_after_processing == 'Yes') {
            // Delete the message afer process
            $fbl->delete();
          }
        }
      } catch (\Exception $e) {}
    }
  }
}
