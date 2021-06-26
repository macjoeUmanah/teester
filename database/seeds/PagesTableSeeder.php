<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
  public function run()
  {
    $pages = [
      [
        'name' => 'Welcome Email',
        'slug' => 'welcome-email',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Welcome!',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <!-- Page container -->
            <div class="page-container " style="min-height: 200px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-2 col-md-3"></div>
                    <div class="col-sm-8 col-md-6">
                      <h2 class="text-semibold mt-40 text-white">[$list-name$]</h2>
                      <div class="panel panel-body">
                        <h4>Your subscription to the list has been confirmed.</h4>
                        <hr />
                        <p>If at any time you wish to stop receiving the emails, you can: <br /> <a href="[$unsub-link$]" class="btn btn-info bg-teal-800">Unsubscribe here</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Confirmation Email (Web From)',
        'slug' => 'confirm-email-webform',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Registration confirmation',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <h2>Hello [#first-name#], welcome to MailCarry</h2>
            <div class="page-container" style="min-height: 249px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-8 col-md-6">
                      <div class="panel panel-body">
                        <h4>Please confirm your registration</h4>
                        <hr />Click the link below to confirm your account:<br /><a href="[$confirm-link$]">[$confirm-link$]</a><br /><hr />
                        <p>&nbsp;</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Confirmation Email (App)',
        'slug' => 'confirm-email-app',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Registration confirmation',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <h2>Hello [#first-name#], welcome to MailCarry</h2>
            <div class="page-container" style="min-height: 249px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-8 col-md-6">
                      <div class="panel panel-body">
                        <h4>Please confirm your registration</h4>
                        <hr />Click the link below to confirm your account:<br /><a href="[$confirm-link$]">[$confirm-link$]</a><br /><hr />
                        <p>&nbsp;</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Notification Email (Contact Added)',
        'slug' => 'notify-email-contact-added',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Contact has been added to a list',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <h2>[$list-name$]</h2>
            <div class="page-container" style="min-height: 249px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-8 col-md-6">
                      <div class="panel panel-body">
                        <h4>[$receiver-email$], has been added. </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Notification Email (Contact Confirmed)',
        'slug' => 'notify-email-contact-confirm',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Contact has been confirmed',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <h2>[$list-name$]</h2>
            <div class="page-container" style="min-height: 249px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-8 col-md-6">
                      <div class="panel panel-body">
                        <h4>[$receiver-email$], has been added. </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Notification Email (Contact Unsubscribed)',
        'slug' => 'notify-email-contact-unsub',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Contact has been unsubscribed',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <h2>[$list-name$]</h2>
            <div class="page-container" style="min-height: 249px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-8 col-md-6">
                      <div class="panel panel-body">
                        <h4>[$receiver-email$], has been added. </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Unsubscribe Email',
        'slug' => 'unsub-email',
        'type' => 'Email',
        'app_id' => 1,
        'email_subject' => 'Unsubscribed',
        'content_html' => '<!DOCTYPE html>
          <html>
          <head>
          </head>
          <body>
            <!-- Page container -->
            <div class="page-container" style="min-height: 200px;">
              <div class="page-content">
                <div class="content-wrapper">
                  <div class="row">
                    <div class="col-sm-2 col-md-3"></div>
                    <div class="col-sm-8 col-md-6"><!-- form -->
                      <h2 class="text-semibold mt-40 text-white">[$list-name$]</h2>
                      <div class="panel panel-body">
                        <h4>Your email address has been removed for the list</h4>
                        <hr />
                        <p>We are sorry to see you go.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Thankyou Page',
        'slug' => 'thankyou',
        'type' => 'Page',
        'app_id' => 1,
        'email_subject' => null,
        'content_html' => '<!DOCTYPE html>
          <html>
          <head><title>Subscription Confirmed</title></head>
          <body>
          <!-- Page container -->
          <div class="page-container" style="min-height: 200px;">
            <div class="page-content">
              <div class="content-wrapper">
                <div class="row">
                  <div class="col-sm-2 col-md-3"></div>
                    <div class="col-sm-8 col-md-6">
                      <h2 class="text-semibold mt-40 text-white">[$list-name$]</h2>
                      <div class="panel panel-body">
                        <h4>Subscription Confirmed</h4>
                        <hr />
                        <p>Your subscription to the list has been confirmed.</p>
                        <p>Thank you for subscribing!</p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Unsubscribe Page',
        'slug' => 'unsub',
        'type' => 'Page',
        'app_id' => 1,
        'email_subject' => null,
        'content_html' => '<!DOCTYPE html>
          <html>
          <head><title>Unsubscribe</title></head>
          <body>
          <!-- Page container -->
          <div class="page-container" style="min-height: 200px;">
            <div class="page-content">
              <div class="content-wrapper">
                <div class="row">
                  <div class="col-sm-2 col-md-3"></div>
                    <div class="col-sm-8 col-md-6">
                      <h2 class="text-semibold mt-40 text-white">[$list-name$]</h2>
                      <div class="panel panel-body">
                        <h4>Unsubscribe Successful</h4>
                        <hr />
                        <p>You have been removed from [$list-name$]</p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /page container -->
          </body>
          </html>'
      ],
      [
        'name' => 'Confirmation Page (Web From)',
        'slug' => 'confirm',
        'type' => 'Page',
        'app_id' => 1,
        'email_subject' => null,
        'content_html' => '<!DOCTYPE html>
          <html>
          <head><title>Subscription Confirmed</title></head>
          <body>
          <!-- Page container -->
          <div class="page-container" style="min-height: 200px;">
            <div class="page-content">
              <div class="content-wrapper">
                <div class="row">
                  <div class="col-sm-2 col-md-3"></div>
                    <div class="col-sm-8 col-md-6">
                      <h2 class="text-semibold mt-40 text-white">[$list-name$]</h2>
                      <div class="panel panel-body">
                        <h4>Your subscription to the list has been confirmed.</h4>
                        <hr />
                        <p>Thank you for subscribing!</p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /page container -->
          </body>
          </html>'
      ],
    ];
    DB::table('pages')->truncate();
    DB::table('pages')->insert($pages);
  }
}
