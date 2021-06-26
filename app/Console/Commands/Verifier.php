<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Helper;
use DB;

class Verifier extends Command
{
  protected $signature = 'mc:verifier';
  protected $description = 'Verify some application modules';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {

    // Check sending domains keys verifications

    try {
      $this->domainVerifications();
    } catch(\Exception $e) {
      \Log::error('mc:verifier => '.$e->getMessage());
    }

    // Check DNSLB Lookups
    try {
      Helper::checkIPsDomainsLookup();
    } catch(\Exception $e) {
      \Log::error('mc:verifier => '.$e->getMessage());
    }

    try {
      $this->verify();
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:verifier => '.$e->getMessage());
    }

    // Check if update is available
    try {
      $this->checkUpdateAvailable();
    } catch(\Exception $e) {
      \Log::error('mc:verifier => '.$e->getMessage());
    }
  }

  /**
   * Verify sending domains keys dkim, dmarc, spf, tracking
  */
  private function domainVerifications()
  {
    $sending_domains = \App\Models\SendingDomain::whereActive('yes')->get();

    foreach($sending_domains as $sending_domain) {
      Helper::verifyDKIM($sending_domain);

      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify Tracking
      Helper::verifyTracking($sending_domain);

      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify SPF
      Helper::verifySPF($sending_domain);

      // 2 sec delay to get dns entries angain
      sleep(2);
      // Verify SPF
      Helper::verifyDMARC($sending_domain);
    }

  }

  /**
   * Verify License to App work smoothly
   * WARNING!!! Avoid to make any changes in it.
  */
  private function verify()
  {
    $settings = DB::table('settings')->whereId(config('mc.app_id'))->select('license_key', 'server_ip', 'app_url')->first();
    $data = [
      'is_auto_verify' => true,
      'license_key' => $settings->license_key,
      'server_ip' => $settings->server_ip
    ];

    try {
      $result = json_decode(Helper::verifyLicense($data), true);
      if(!empty($result['message']) && $result['message'] == 'Invalid License Key') {
         DB::table('settings')->whereId(config('mc.app_id'))->update(['license_key' => null]);
      }
    } catch(\Exception $e) {
      \Log::error('mc:verifier => '.$e->getMessage());
    }
  }

  /**
   * Verify License to App work smoothly
   * WARNING!!! Avoid to make any changes in it.
  */
  private function checkUpdateAvailable()
  {
    $settings = DB::table('settings')->whereId(config('mc.app_id'))->select('license_key', 'server_ip', 'app_url')->first();
    $current_version = Helper::getUrl($settings->app_url.config('mc.version_local_path'));
    $available_version = Helper::getUrl(config('mc.version_live_path'));

    if($available_version > $current_version) {
      // save notification
      $notification = [
        'name' => __('app.update_available_msg'),
        'type' => 'update',
        'attributes' => null,
        'app_id' => config('mc.app_id'),
        'user_id' => config('mc.superadmin')
      ];
      \App\Models\Notification::create($notification);
    }
  }
}
