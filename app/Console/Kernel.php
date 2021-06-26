<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected $commands = [];

  protected function schedule(Schedule $schedule)
  {
    // For safe side, if someone is missed to execute
    $schedule->command('queue:work --once')->everyMinute();

    // Every 1 Minute
    $schedule->command('mc:process-campaign')->everyMinute();
    $schedule->command('mc:process-trigger')->everyMinute();
    $schedule->command('mc:process-triggerschedules')->everyMinute();
    $schedule->command('mc:process-segments')->everyMinute();
    $schedule->command('mc:process-drip')->everyMinute();
    $schedule->command('mc:maintainer')->everyMinute();

    // Every 5 Minutes
    $schedule->command('mc:cleaner')->everyFiveMinutes();

    // Every 30 Minutes
    $schedule->command('mc:settings')->everyThirtyMinutes();

    // Hourly
    //$schedule->command('mc:process-bounces')->hourly();
    //$schedule->command('mc:process-fbls')->hourly();

    // Run every two hour
    $schedule->command('mc:process-bounces')->cron('0 */2 * * *');
    $schedule->command('mc:process-fbls')->cron('0 */2 * * *');

    // Daily
    $schedule->command('mc:verifier')->daily();
    $schedule->command('activitylog:clean')->daily();
  }

  protected function commands()
  {
      $this->load(__DIR__.'/Commands');

      require base_path('routes/console.php');
  }
}
