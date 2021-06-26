<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bounce;
use Helper;

use Webklex\IMAP\Client;

class ProcessBounces extends Command
{
  protected $signature = 'mc:process-bounces';
  protected $description = 'Process the bounces';
  public $code = '5.1.1';
  public $type = 'Hard';
  public $short_detail = null;
  public $message_id = null;
  public $to = null;
  public $full_detail = null;
  public $app_id = 1;

  public function __construct()
  {
      parent::__construct();
  }

  public function handle()
  {
    // Proces system bounces
    try {
      $this->systemBounces();
    } catch (\Exception $e) {
      $error = $e->getMessage();
      \Log::error("mc:process-bounces-systemBounces => ".$error);
    }

    // Process PMTA bounces
    try {
      $this->pmtaBounces();
    } catch (\Exception $e) {
        $error = $e->getMessage();
        \Log::error("mc:process-bounces-PMTAbounces => ".$error);
      }
  }

  private function systemBounces()
  {
    $bounces = Bounce::active()->get();
    foreach($bounces as $bounce) {
      $validate_cert = $bounce->validate_cert == 'Yes' ? true : false;
      $password = !empty($bounce->password) ? \Crypt::decrypt($bounce->password) : '';
      $oClient = new Client([
        'host'          => $bounce->host,
        'port'          => $bounce->port,
        'encryption'    => $bounce->encryption,
        'validate_cert' => $validate_cert,
        'username'      => $bounce->username,
        'password'      => $password,
        'protocol'      => $bounce->method
      ]);

      try {
        //Connect to the IMAP Server
        $oClient->connect();
        //Get all Mailboxes
        try {
          // false due to get office 365 emails
          $aFolder = $oClient->getFolders(false);
        } catch (\Exception $e) {
          $error = $e->getMessage();
        }
        //Loop through every Mailbox
        foreach($aFolder as $oFolder){
          //Get 1 day old Messages of the current Mailbox $oFolder with limit 10 of page-no upto 50 pages
          for($page=1; $page<100; $page++) {
           $aMessage = $oFolder->query()->since(now()->subDays(1))->limit(10, $page)->get();
            foreach($aMessage as $oMessage) {
              $aAttachment = $oMessage->getAttachments();
              $aAttachment->each(function ($oAttachment) use ($oMessage) {
              $content =  $oAttachment->getContent();
                // Get bounce type and short detail
                $code = Helper::extractString($content, 'Status:', "\n");

                // Avoid to save the data for X-OutGoing-Spam-Status: No, score=-1.0
                if(stripos($code, 'score') === false) {
                  if(!empty($code)) {
                    $bounce_code_detail = Helper::bouceCodes($code);
                    if(!empty($bounce_code_detail)) {
                      $this->type = $bounce_code_detail['type'];
                      $this->short_detail = $bounce_code_detail['description'];
                      $this->code = $code;
                    }
                  }
                  //$this->to = str_replace('rfc822;', '', Helper::extractString($content, 'Final-Recipient:', "\n"));
                  $this->full_detail = !empty($oMessage->getTextBody()) ? $oMessage->getTextBody() : $oMessage->getHTMLBody(true);
                }

                if(strpos($content, 'Message-ID:') !== false) {
                  $this->message_id = Helper::extractString($content, 'Message-ID:', "\n");
                  try {
                    // To process only campaign bounces; mc_type can be drip etc
                    $mc_type = Helper::extractString($content, 'MC-Type-ID:', "\n");
                  } catch(\Exception $e) {
                    $mc_type = 'campaign';
                  }

                  list($app_id, $stat_id, $to_email, $section) = $this->toEamil_Section($mc_type);

                  Helper::saveBounce($to_email, $stat_id, $section, $this->code, $this->type, $this->short_detail, $this->full_detail, $app_id);
                }
              });

              if($bounce->delete_after_processing == 'Yes') {
                // Delete the message afer process
                $oMessage->delete();
              }
            }
          }
        }
      } catch (\Exception $e) {
        $error = $e->getMessage();
        \Log::error("mc:process-bounces-systemBounces => ".$error);
      }
    }
  }

  private function pmtaBounces()
  {
    $pmta = json_decode(\DB::table('settings')->whereId(config('mc.app_id'))->value('pmta'));
    if(!empty($pmta)) {
      $sftp = new \phpseclib\Net\SFTP($pmta->server_ip, $pmta->server_port);
      if (!$sftp->login($pmta->server_username, $pmta->server_password)) {
         \Log::error('mc:process-bounces => PMTA server not connected');
      } else {
        $path_pmta = str_replace('[user-id]', config('mc.app_id'), config('mc.path_pmta'));
        Helper::dirCreateOrExist($path_pmta); // create dir if not exist

        $acct_file_path = substr($pmta->acct_file_path, 0, strrpos($pmta->acct_file_path, '/'));
        $files = $sftp->nlist($acct_file_path);
        foreach($files as $file) {

          if($file == '.' || $file == '..') continue;

          $filetime_last_modified = date('Y-m-d H:i:s', $sftp->filemtime($acct_file_path.'/'.$file));
          //echo date('Y-m-d',$filetime_last_modified);

          $yesterday = \Carbon\Carbon::parse(\Carbon\Carbon::now())->subDays(1);

          // only pick oneday old files, otherwise it will kill server resources about DB
          if(strtotime($filetime_last_modified) > strtotime($yesterday)) {

            $dest_file = $path_pmta.'/'.$file;

            $data = $sftp->get($acct_file_path.'/'.$file, $dest_file);

            $reader = \League\Csv\Reader::createFromPath($dest_file, 'r');

            // Make associative array with names and skipp header
            $reader->setHeaderOffset(0);

            $records = $reader->getRecords();

            foreach ($records as $offset => $record) {
              if(trim($record['dsnAction']) == 'failed' && !empty($record['jobId'])) {
                list($app_id, $stat_id, $to_email, $section) = $this->toEamil_Section($record['jobId']);

                $code = substr($record['dsnStatus'],0,5);
                $bounce_code_detail = Helper::bouceCodes($code);
                $type = $bounce_code_detail['type'] ?? $this->type;
                $short_detail  = substr($record['dsnStatus'],7,-1);
                $full_detail  = $record['dsnDiag'];
                Helper::saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id);
              }
            }
            unlink($dest_file);
          }
        }
      }
    }
  }


  private function toEamil_Section($mc_type)
  {
    try {
      $stat_id = explode('-', $mc_type)[1];
    } catch(\Exception $e) {
      $stat_id = 0;
    }

    try {
      $app_id = explode('-', $mc_type)[2];
    } catch(\Exception $e) {
      $app_id = $this->app_id;
    }

    $section = 'Campaign';
    $to_email = null;

    if($stat_id) {
      if(stripos($mc_type, 'campaign') !== false) {
        \App\Models\ScheduleCampaignStatLog::whereId($stat_id)->update(['status' => 'Bounced']);
        $to_email = \App\Models\ScheduleCampaignStatLog::whereId($stat_id)->value('email');
      } if(stripos($mc_type, 'drip') !== false) {
        \App\Models\ScheduleDripStatLog::whereId($stat_id)->update(['status' => 'Bounced']);
        $to_email = \App\Models\ScheduleDripStatLog::whereId($stat_id)->value('email');
        $section = 'Drip';
      } if(stripos($mc_type, 'autofollowup') !== false) {
        \App\Models\AutoFollowupStatLog::whereId($stat_id)->update(['status' => 'Bounced']);
        $to_email = \App\Models\AutoFollowupStatLog::whereId($stat_id)->value('email');
        $section = 'AutoFollowup';
      }
    }

    return [
      $app_id,
      $stat_id,
      $to_email,
      $section
    ];
  }
}
