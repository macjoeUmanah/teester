<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Cleaner extends Command
{
  protected $signature = 'mc:cleaner';
  protected $description = 'Clean DB and extra files';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Clean DB soft deleted
    try {
      $this->cleanDBWithSoftDelets();
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:1 => '.$e->getMessage());
    }

    // Clean unnecessary files
    try {
      $this->cleanFiles();
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:2 => '.$e->getMessage());
    }

    // Clean trigger logs
    try {
      $this->cleanTriggerLogs();
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:3 => '.$e->getMessage());
    }
  }

  /**
   * Clean DB with soft deleted recods
  */
  protected function cleanDBWithSoftDelets()
  {
      // Soft Deleted Users
    try {
      $soft_deleted_users = \App\Models\User::onlyTrashed()->get();
      foreach($soft_deleted_users as $user) {
        // should be delete lists it is assoicate with sending servers and will create trouble when delete
        $lists = \App\Models\Lists::whereAppId($user->app_id)->get();
        foreach($lists as $list) {
          \App\Models\Lists::destroy($list->id);
        }

        // delte roles
        $roles = \Spatie\Permission\Models\Role::whereAppId($user->app_id)->get();
        foreach($roles as $role) {
          \Spatie\Permission\Models\Role::destroy($role->id);
        }

        // delete users
        $user->forceDelete();
      }
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:3 => '.$e->getMessage());
    }

    try {
      // Soft Deleted Groups
      $soft_deleted_groups = \App\Models\Group::onlyTrashed()->get();
      foreach($soft_deleted_groups as $group) {
        $group->forceDelete();
      }
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:4 => '.$e->getMessage());
    }

    try {
      // Soft Deleted Lists
      $soft_deleted_lists = \App\Models\Lists::onlyTrashed()->get();
      foreach($soft_deleted_lists as $list) {
        $list->forceDelete();
      }
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:5 => '.$e->getMessage());
    }

    try {
      // Soft Deleted Broadcasts
      $soft_deleted_broadcasts = \App\Models\Broadcast::onlyTrashed()->get();
      foreach($soft_deleted_broadcasts as $broadcast) {
        $broadcast->forceDelete();
      }
    } catch(\Exception $e) {
      echo $e->getMessage();
      \Log::error('mc:cleaner:6 => '.$e->getMessage());
    }
  }

  /**
   * Clean unnecessary files
  */
  protected function cleanFiles()
  {
    // Remove completed campaign files
    $schedules = \App\Models\ScheduleCampaign::whereStatus('Completed')
      ->select('id', 'user_id')
      ->orderBy('id', 'desc')
      ->get();

    if(count($schedules) > 0) {
      foreach($schedules as $schedule) {
        $path_schedule_campaign = str_replace('[user-id]', $schedule->user_id, config('mc.path_schedule_campaign'));
        $dir = $path_schedule_campaign.$schedule->id.DIRECTORY_SEPARATOR;
        if(is_dir($dir)) {
          try {
            $files = scandir($dir);
          } catch (\Exception $e) {
            \Log::error('mc:cleaner:7 => '.$e->getMessage());
          }

          try {
            foreach($files as $file_no) {
              $file = $dir.$file_no;
              try {
                unlink($file);
              } catch (\Exception $e) {
                \Log::error('mc:cleaner:8 => '.$e->getMessage());
              }
            }
            rmdir($dir);
          } catch (\Exception $e) {
            \Log::error('mc:cleaner:9 => '.$e->getMessage());
          }
        }
      }
    }
    

    // If campaing is deleted
    $users = \App\Models\User::all();

    foreach($users as $user) {
      $path_schedule_campaign = str_replace('[user-id]', $user->id, config('mc.path_schedule_campaign'));
      try {
        $dirs = scandir($path_schedule_campaign);
      } catch (\Exception $e) {
        // nothing to write otherwise lot of unnecessary data writes
      }
      foreach($dirs as $dir_id) {
        // no need to delete other director files
        if(\App\Models\ScheduleCampaign::whereId($dir_id)->exists()) continue;

        if($dir_id != '.' && $dir_id != '..') {
          $dir = $path_schedule_campaign.$dir_id.DIRECTORY_SEPARATOR;
          if(is_dir($dir)) {
            try {
              $files = scandir($dir);
            } catch (\Exception $e) {
              \Log::error('mc:cleaner:11 => '.$e->getMessage());
            }

            try {
              foreach($files as $file_no) {
                $file = $dir.$file_no;
                try {
                  unlink($file);
                } catch (\Exception $e) {
                  \Log::error('mc:cleaner:12 => '.$e->getMessage());
                }
              }
              rmdir($dir);
            } catch (\Exception $e) {
            \Log::error('mc:cleaner:13axc => '.$e->getMessage());
            }
          }
        }
      }
    }
  }

  /**
   * Clean the trigger logs upto 5 days
  */
  protected function cleanTriggerLogs()
  {
    \DB::table('trigger_logs')->where('created_at', '<', \Carbon\Carbon::now()->subDay(5))->delete();
  }
}
