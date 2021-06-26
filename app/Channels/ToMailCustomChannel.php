<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class ToMailCustomChannel
{
  /**
   * Custom channel to overwrite default laravel sending notification channel
  */
  public function send($notifiable, Notification $notification)
  {
    $message = $notification->toMailCustom($notifiable);
  }
}