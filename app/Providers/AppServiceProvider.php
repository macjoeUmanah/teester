<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;
use Auth;

class AppServiceProvider extends ServiceProvider
{
  public function boot()
  {
    // Default string length if not defined in migration
    Schema::defaultStringLength(191);

    View::composer('*', function ($view) {
      // get app settings
      $settings_views = [
        'layouts.app',
        'tools.images_manager',
        'auth.login',
        'auth.passwords.email',
        'auth.passwords.reset',
        'errors::404'
      ];

      $view_name = $view->getName();

      if(in_array($view_name, $settings_views)) {
        $settings = \DB::table('settings')->whereId(config('mc.app_id'))->first();
        $settings->current_version = \Helper::getUrl($settings->app_url.config('mc.version_local_path'));
        $view->with('settings', $settings);

      }

      // No need to execute the queries for all views
      if($view_name == 'layouts.app' || $view_name == 'tools.images_manager' || $view_name == 'errors::404') {
        // Check installed file exist
        if(!file_exists(storage_path('app/public/installed'))) {
          header('Location: '. url('/').'/install');
          exit;
        }

        // get notifications inside if due to Auth not availabe outside
        $notifications = \App\Models\Notification::notifications();
        $view->with('notifications', $notifications);
        if(Auth::user()) {
          $view->with('time_zone', Auth::user()->time_zone);
        }

        try {
          if(Auth::user()->active == 'No') {
            Auth::logout();
          }
        } catch(\Exception $e) {}
      }
    });
  }

  public function register() {}
}
