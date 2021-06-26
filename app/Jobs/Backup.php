<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Process;

class Backup implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $process, $user_id, $app_id, $backup_db, $backup_files;
  public $tries = 3;

  public function __construct($user_id, $app_id, $backup_db, $backup_files)
  {
    $this->user_id = $user_id;
    $this->app_id = $app_id;
    $this->backup_db = $backup_db;
    $this->backup_files = $backup_files;
  }

  public function handle()
  {
    if($this->backup_files || $this->backup_db) {
      $path_backup = str_replace('[user-id]', $this->user_id, config('mc.path_backup'));
      \Helper::dirCreateOrExist($path_backup); // create dir if not exist
      $backup_zip = $path_backup.'backup.zip';

      if(is_file($backup_zip)) {
        unlink($backup_zip);
      }

      // if backup is set for files
      if($this->backup_files) {
        $backup_dirs_files = scandir(base_path());

        $zipper = new \Chumper\Zipper\Zipper;
        foreach($backup_dirs_files as $dir_file) {
          // Not need to add thest dir/files
          if(in_array($dir_file, ['.', '..', '.git', 'vendor', 'geo'])) continue;

          is_dir($dir_file)
          ? $zipper->make($backup_zip)->folder($dir_file)->add(base_path().DIRECTORY_SEPARATOR.$dir_file)
          : $zipper->make($backup_zip)->add($dir_file);
        }
        $zipper->close();
      }

      // if backup is set for db
      if($this->backup_db) {
        $file_sql = $path_backup.'database.sql';
        $this->process = new Process(sprintf(
          "mysqldump -u%s -p'%s' %s > %s",
          config('database.connections.mysql.username'),
          config('database.connections.mysql.password'),
          config('database.connections.mysql.database'),
          $file_sql
        ));

        try {
          $this->process->mustRun();
        } catch (Exception $e) {
          $this->error($e->getMessage());
        }

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($backup_zip)->add($file_sql)->close();

        unlink($file_sql);
      }

      // save notification for user to inform and download
      $notification_name = __('app.msg_backup_export_successfully');
      $attributes = [
        'file' => $backup_zip
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
}
