<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use App\Models\ScheduleCampaignStatLogBounce;
use App\Models\ScheduleCampaignStatLogSpam;
use App\Models\Suppression;

class Settings extends Command
{

  protected $signature = 'mc:settings';
  protected $description = 'Process according to settings etc.';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $settings = \DB::table('settings')->whereId(config('mc.app_id'))->first();
    $general_settings = json_decode($settings->general_settings);


    // Update contacts about bounces
    if(!empty($general_settings->bounced_recipients) && $general_settings->bounced_recipients != 'none') {
      $this->updateBouncedContacts($general_settings->bounced_recipients);
    }

    // Update contacts about spam
    if(!empty($general_settings->spam_recipients) && $general_settings->spam_recipients != 'none') {
      $this->updateSpamContacts($general_settings->spam_recipients);
    }

    // Update contacts about suppression
    if(!empty($general_settings->suppressed_recipients) && $general_settings->suppressed_recipients != 'none') {
      $this->updateSuppressedContacts($general_settings->suppressed_recipients);
    }
  }

  private function updateBouncedContacts($bounced_recipients)
  {
    ScheduleCampaignStatLogBounce::whereNotNull('email')->select('email')->chunk(3000, function ($bounces) use ($bounced_recipients) {
        foreach($bounces as $bounced) {
          if($bounced_recipients == 'unsub') {
            Contact::whereEmail($bounced->email)->update(['unsubscribed' => 'Yes']);
          } elseif($bounced_recipients == 'inactive') {
            Contact::whereEmail($bounced->email)->update(['active' => 'No']);
          }
        }
      });
  }

  private function updateSpamContacts($spam_recipients)
  {
    ScheduleCampaignStatLogSpam::whereNotNull('email')->select('email')->chunk(3000, function ($spams) use ($spam_recipients) {
        foreach($spams as $spam) {
          if($spam_recipients == 'unsub') {
            Contact::whereEmail($spam->email)->update(['unsubscribed' => 'Yes']);
          } elseif($spam_recipients == 'inactive') {
            Contact::whereEmail($spam->email)->update(['active' => 'No']);
          }
        }
      });
  }

  private function updateSuppressedContacts($suppressed_recipients)
  {
    Suppression::whereNotNull('email')->select('email')->chunk(3000, function ($suppressed) use ($suppressed_recipients) {
        foreach($suppressed as $suppress) {
          if($suppressed_recipients == 'unsub') {
            Contact::whereEmail($suppress->email)->update(['unsubscribed' => 'Yes']);
          } elseif($suppressed_recipients == 'inactive') {
            Contact::whereEmail($suppress->email)->update(['active' => 'No']);
          }
        }
      });

    // Check suppress data for domains
    $suppress_domains = Suppression::where('email', 'LIKE', '@%')->select('email')->get();
    foreach($suppress_domains as $suppress_domain) {
      if($suppressed_recipients == 'unsub') {
        Contact::where('email', 'LIKE', "%{$suppress_domain->email}")->update(['unsubscribed' => 'Yes']);
      } elseif($suppressed_recipients == 'inactive') {
        Contact::where('email', 'LIKE', "%{$suppress_domain->email}")->update(['active' => 'No']);
      }
    }
  }
}
