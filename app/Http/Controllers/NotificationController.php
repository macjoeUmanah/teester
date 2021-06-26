<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
  /**
   * Update notification after read
  */
  public function read($id)
  {
    $notification = Notification::whereId($id)->first();

    // delete the notification
    Notification::whereId($id)->delete();
    
    if($notification->type == 'export') {
      try {
        $file = json_decode($notification->attributes)->file;
        return response()->download($file)->deleteFileAfterSend(true);
      } catch(\Exception $e) {
        return redirect(url()->previous());
      }
    } elseif($notification->type == 'import') {
      $list_id = json_decode($notification->attributes)->list_id;
      return redirect(route('contacts.index', ['list_id' => $list_id]));
    } else {
      return redirect(url()->previous());
    }
  }

  /**
   * Mark all notification as read
  */
  public function readAll()
  {
    // delete the notification
    Notification::whereAppId(config('mc.app_id'))->delete();
    return redirect(url()->previous());
  }
}
