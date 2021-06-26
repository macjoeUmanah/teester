<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Maintainer extends Command
{
  protected $signature = 'mc:maintainer';
  protected $description = 'Active sending servers and campaigns etc.';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    try {
      $this->setSendingServerSendingLimitCounters();
    } catch(\Exception $e) {
      \Log::error('mc:maintainer-setSendingServerSendingLimitCounters => '.$e->getMessage());
    }
    
    try {
      $this->setSendingServerStatus();
    } catch(\Exception $e) {
      \Log::error('mc:maintainer-setSendingServerStatus => '.$e->getMessage());
    }

    // Should be after setSendingServerStatus() so sending servers already checked
    try {
      $this->setScheduledCampaignStatus();
    } catch(\Exception $e) {
      \Log::error('mc:maintainer-setScheduledCampaignStatus => '.$e->getMessage());
    }

    // If scheduled campaings paused for some reason for a long time then need to reset it
    try {
      $this->resumeScheduleCampaign();
    } catch(\Exception $e) {
      \Log::error('mc:maintainer-resumeScheduleCampaign => '.$e->getMessage());
    }

  }

  /**
   * Re-set the sending limit and set the next timestamp
  */
  protected function setSendingServerSendingLimitCounters()
  {
    \App\Models\SendingServer::where('hourly_sent_next_timestamp', '<', \Carbon\Carbon::now())
      ->update([
        'hourly_sent' => 0,
        'hourly_sent_next_timestamp' => \Carbon\Carbon::now()->addHour(1)
      ]);
    \App\Models\SendingServer::where('daily_sent_next_timestamp', '<', \Carbon\Carbon::now())
      ->update([
        'daily_sent' => 0,
        'daily_sent_next_timestamp' => \Carbon\Carbon::now()->addDay(1)
      ]);
  }

  /**
   * Update the sending server status to active for System Inactive / System Paused
  */
  protected function setSendingServerStatus()
  {
    $sending_servers = \App\Models\SendingServer::WhereIn('status', ['System Inactive', 'System Paused'])->get();
    foreach($sending_servers as $sending_server) {
      $status = null;
      if($sending_server->status == 'System Paused') {
        $speed_attributes = json_decode($sending_server->speed_attributes);
        if($speed_attributes->speed == 'Limited') {
          if($speed_attributes->duration == 'hourly') {
            if($sending_server->hourly_sent < $speed_attributes->limit) {
              $status = 'Active';
            }
          } elseif($speed_attributes->duration == 'daily') {
            if($sending_server->daily_sent < $speed_attributes->limit) {
              $status = 'Active';
            }
          }
        } else {
          $status = 'Active';
        }
      } elseif($sending_server->status == 'System Inactive') {
        $connection = \Helper::configureSendingNode($sending_server->type, $sending_server->sending_attributes);
        if($connection['success']) {
          $status = 'Active';
        }
      }

      if(!empty($status)) {
        \App\Models\SendingServer::whereId($sending_server->id)
        ->update([
          'status' => $status,
          'notification' => null
        ]);
      }
    }
  }

  /**
   * Update the scheduled campaigns status to active System Paused
  */
  protected function setScheduledCampaignStatus()
  {
    $schedules = \App\Models\ScheduleCampaign::whereStatus('System Paused')
      ->select('id', 'sending_server_ids', 'sending_speed')->get();
    foreach($schedules as $schedule) {
      $sending_serves = \App\Models\SendingServer::WhereIn('id', explode(',', $schedule->sending_server_ids))
      ->where('status', 'Active')
      ->get();

      if(!empty($sending_serves)) {
        // Scheduled and RunningLimit will be entertain again
        if(json_decode($schedule->sending_speed)->limit) {
          \App\Models\ScheduleCampaign::whereId($schedule->id)
            ->update([
              'status' => 'RunningLimit',
              'send_datetime' => \Carbon\Carbon::now()
            ]);
        } else {
          \App\Models\ScheduleCampaign::whereId($schedule->id)
            ->update([
              'status' => 'Resume',
              'thread_no' => 1
            ]);
        };
        
      }
    }
  }

  /**
   * If scheduled campaings paused for some reason for a long time then need to reset or send remaining
  */
  protected function resumeScheduleCampaign()
  {
    // rest with 3 hour check
    $campaing_schedules = \App\Models\ScheduleCampaign::whereIn('status', ['Running', 'RunningLimit'])
      ->where('updated_at', '<', \Carbon\Carbon::now()->subHours(3))
      ->whereRaw('thread_no >= total_threads')
      ->whereRaw('sent < total')
      ->get();

    foreach($campaing_schedules as $schedule) {
      \App\Models\ScheduleCampaign::whereId($schedule->id)
        ->update([
          'status' => 'Resume',
          'thread_no' => 1
        ]);
    }
  }
}
