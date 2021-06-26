<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\ToMailCustomChannel;
use Helper;

class ResetPassword extends Notification
{
    use Queueable;
    private $token;
    public function __construct($token)
    {
      $this->token = $token;
    }

    public function via($notifiable)
    {
      return [ToMailCustomChannel::class];
    }

    public function toMailCustom($notifiable)
    {
      $settings = \DB::table('settings')->whereId(config('mc.app_id'))->first();
      $connection = Helper::configureSendingNode($settings->sending_type, $settings->sending_attributes);

      // If no connection available then should be send as php mail function
      if(!$connection['success']) {
        $connection = Helper::configureSendingNode('php_mail', $settings->sending_attributes);
      }

      if($connection['success']) {
        $email_content = $this->forgotEmailcontent($notifiable, $settings);

        if(in_array($settings->sending_type, Helper::sendingServersFramworkSuported())) {
          $message = new \Swift_Message();
          $message->setFrom($settings->from_email, $settings->app_name);
          $message->setId(Helper::getCustomMessageID());
          $message->setTo($notifiable->email, $notifiable->name);
          $message->setSubject("{$settings->app_name} - Reset your password");
          $message->setBody($email_content, "text/html");
          try {
            $connection['transport']->send($message);
            session()->flash('msg', __('app.msg_password_reset_email_success'));
            session()->flash('alert-class', 'text-success');
          } catch(\Exception $e) {
            session()->flash('msg', $e->getMessage());
            session()->flash('alert-class', 'text-danger');
          }
        } elseif($settings->sending_type == 'sendgrid_api') {
          $message = new \SendGrid\Mail\Mail();
          $message->addTo($notifiable->email, $notifiable->name);
          $message->setFrom($settings->from_email, $settings->app_name);
          $message->setSubject("{$settings->app_name} - Reset your password");
          $message->addContent("text/html", $email_content);
          $sendgrid = new \SendGrid(\Crypt::decrypt(json_decode($settings->sending_attributes)->api_key));
          try {
            $response = $sendgrid->send($message);
            // status start with 2 consider as sent
            if(substr($response->statusCode(), 1) == 2) {
              session()->flash('msg', __('app.msg_password_reset_email_success'));
              session()->flash('alert-class', 'text-success');
            } else {
              session()->flash('msg', json_decode($response->body())->errors[0]->message);
              session()->flash('alert-class', 'text-danger');
            }
          } catch(\Exception $e) {
            echo $e->getMessage();
            $status = 'Failed';
          }
        }
      } else {
        session()->flash('msg', __($connection['msg']));
        session()->flash('alert-class', 'text-danger');
      }
    }

    /**
     * Return content that will be send for forgot password
    */
    public function forgotEmailcontent($notifiable, $settings)
    {
      return "<!DOCTYPE html><html>
<head>
  <title>{$settings->app_name}</title>
</head>
<body>
  Dear {$notifiable->name}, <br/>
  <h3>Can't remember your password?</h3>
  <p>
    Don't worry, it may happens. We can help.
  </p>
  <p>
    <strong>Email:</strong> {$notifiable->email}
  </p>
  <p>
    Use this link to reset your password:<a href='{$settings->app_url}/password/reset/{$this->token}'> {$settings->app_url}/password/reset/{$this->token} </a>
  </p>
  <br/>
  Thank you,
  <br/>
  {$settings->app_name}
</body>
</html>";
    }
}
