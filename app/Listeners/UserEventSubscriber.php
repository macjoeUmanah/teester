<?php

namespace App\Listeners;

class UserEventSubscriber
{
  /**
   * Handle user login events.
   */
  public function onUserLogin($event)
  {
    activity('signin')->withProperties(['app_id' => $event->user->app_id])->log("({$event->user->email}) ". __('app.log_signin')); // log
  }

  /**
   * Handle user logout events.
   */
  public function onUserLogout($event) 
  {
    activity('logout')->withProperties(['app_id' => $event->user->app_id])->log("({$event->user->email}) ". __('app.log_logout')); // log
  }

  /**
   * Register the listeners for the subscriber.
   *
   * @param  \Illuminate\Events\Dispatcher  $events
   */
  public function subscribe($events)
  {
      $events->listen(
          'Illuminate\Auth\Events\Login',
          'App\Listeners\UserEventSubscriber@onUserLogin'
      );

      $events->listen(
          'Illuminate\Auth\Events\Logout',
          'App\Listeners\UserEventSubscriber@onUserLogout'
      );
  }
}