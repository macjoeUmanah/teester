<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\ToMailCustomChannel;
use Helper;

class ContactAdded extends Notification implements ShouldQueue
{
  use Queueable;
  private $subscriber_email;
  private $notify_action;
  private $notify_email;

  public function __construct($subscriber_email, $notify_action, $notify_email)
  {
    $this->subscriber_email = $subscriber_email;
    $this->notify_action = $notify_action;
    $this->notify_email = $notify_email;
  }

  public function via($notifiable)
  {
    return [ToMailCustomChannel::class];
  }

  public function toMailCustom($notifiable)
  {
    // need to get customfields associat with contact so find contact
    $contact = \App\Models\Contact::findOrFail($notifiable->id);
    $notification_attributes = json_decode($contact->list->notification_attributes, true);
    $attributes = json_decode($contact->list->attributes);


    $sending_server = \App\Models\SendingServer::whereId($contact->list->sending_server_id)
      ->whereStatus('Active')
      ->with('bounce')
      ->first();

    if(!empty($sending_server->id)) {
      $connection = Helper::configureSendingNode($sending_server->type, $sending_server->sending_attributes);

      if($connection['success']) {

        // If Unsubscribe Email is set to 'Yes' for a list
        if($contact->list->double_optin == 'Yes' || $contact->list->welcome_email == 'Yes' || $contact->list->unsub_email == 'Yes') {
          // send email to contact 
          $send_email = false; //' It may possilbe one option is true other false
          // Run old emails that have no value set
          if(($this->subscriber_email == 'confirm-email-app' || $this->subscriber_email == 'confirm-email-webform') && $contact->list->double_optin == 'Yes') {
            if(!empty($attributes->confirmation_email_id)) {
               $page = \App\Models\Page::whereId($attributes->confirmation_email_id)->whereAppId($contact->app_id)->first();
            } else {
              $page = \App\Models\Page::whereSlug($this->subscriber_email)->whereAppId($contact->app_id)->first();
            }
            $send_email = true;
          } elseif($this->subscriber_email == 'welcome-email' && $contact->list->welcome_email == 'Yes') {
            if(!empty($attributes->welcome_email_id)) {
               $page = \App\Models\Page::whereId($attributes->welcome_email_id)->whereAppId($contact->app_id)->first();
            } else {
              $page = \App\Models\Page::whereSlug($this->subscriber_email)->whereAppId($contact->app_id)->first();
            }
            $send_email = true;
          } elseif($this->subscriber_email == 'unsub-email' && $contact->list->unsub_email == 'Yes') {
            if(!empty($attributes->unsub_email_id)) {
               $page = \App\Models\Page::whereId($attributes->unsub_email_id)->whereAppId($contact->app_id)->first();
            } else {
              $page = \App\Models\Page::whereSlug($this->subscriber_email)->whereAppId($contact->app_id)->first();
            }
            $send_email = true;
          }

          if($send_email) {
            $content = Helper::replaceSpintags(Helper::decodeString($page->content_html)); // replace spintags
            $content = Helper::replaceCustomFields($content, $contact->customFields); // replace custom field
            $content = Helper::replaceSystemVariables($contact, $content, $data_values=[]); // replace system variables

            $subject = Helper::replaceSpintags(Helper::decodeString($page->email_subject)); // replace spintags
            $subject = Helper::replaceCustomFields($subject, $contact->customFields); // replace custom field
            $subject = Helper::replaceSystemVariables($contact, $subject, $data_values=[]); // replace system variables

            $message = Helper::configureEmailBasicSettings($sending_server);
            if(in_array($sending_server->type, Helper::sendingServersFramworkSuported())) {
              $message->setTo($contact->email);
              $message->setSubject($subject);
              $message->setBody($content, "text/html");
              try {
                $connection['transport']->send($message);
                $status = 'Sent';
              } catch(\Exception $e) {
                //echo $e->getMessage();
                $status = 'Failed';
              }
            } elseif($sending_server->type == 'sendgrid_api') {
              $message->addTo($contact->email);
              $message->setSubject($subject);
              $message->addContent("text/html", $content);
              $sendgrid = new \SendGrid(\Crypt::decrypt(json_decode($sending_server->sending_attributes)->api_key));
              try {
                $response = $sendgrid->send($message);
                // status start with 2 consider as sent
                if(substr($response->statusCode(), 1) == 2) {
                  $status = 'Sent';
                } else {
                  $status = 'Failed';
                }
              } catch(\Exception $e) {
                //echo $e->getMessage();
                $status = 'Failed';
              }
            }

            if($status == 'Sent') {
              Helper::updateSendingServerCounters($sending_server->id);
            }
          }
        }

        // send notification email
        if($contact->list->notification == 'Enabled' && in_array($this->notify_action, $notification_attributes['criteria'])) {
          $page = \App\Models\Page::whereSlug($this->notify_email)->whereAppId($contact->app_id)->first();

          $content = Helper::replaceSpintags($page->content_html); // replace spintags
          $content = Helper::replaceCustomFields($content, $contact->customFields); // replace custom field
          $content = Helper::replaceSystemVariables($contact, $content, $data_values=[]); // replace system variables

          $subject = Helper::replaceSpintags($page->email_subject); // replace spintags
          $subject = Helper::replaceCustomFields($subject, $contact->customFields); // replace custom field
          $subject = Helper::replaceSystemVariables($contact, $subject, $data_values=[]); // replace system variables

          $message = Helper::configureEmailBasicSettings($sending_server);
          if(in_array($sending_server->type, Helper::sendingServersFramworkSuported())) {
              $message->setTo($notification_attributes['email']);
              $message->setSubject($subject);
              $message->setBody($content, "text/html");
              try {
                $connection['transport']->send($message);
                $status = 'Sent';
              } catch(\Exception $e) {
                //echo $e->getMessage();
                $status = 'Failed';
              }
          } elseif($sending_server->type == 'sendgrid_api') {
            $message->addTo($notification_attributes['email']);
            $message->setSubject($subject);
            $message->addContent("text/html", $content);
            $sendgrid = new \SendGrid(json_decode($sending_server->sending_attributes)->api_key);
            try {
              $response = $sendgrid->send($message);
              $status = 'Sent';
            } catch(\Exception $e) {
              //echo $e->getMessage();
              $status = 'Failed';
            }
          }

          if($status == 'Sent') {
            Helper::updateSendingServerCounters($sending_server->id);
          }
        }
      } // if($connection['success'])
    } // If !empty($sending_server->id)
  }
}
