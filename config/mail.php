<?php

return [
  'driver' => env('MAIL_DRIVER', 'sendmail'),
  'host' => env('MAIL_HOST', 'smtp.mailcarry.com'),
  'port' => env('MAIL_PORT', 587),
  'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'imran@mailcarry.com'),
    'name' => env('MAIL_FROM_NAME', 'MailCarry'),
  ],
  'encryption' => env('MAIL_ENCRYPTION', 'tls'),
  'username' => env('MAIL_USERNAME'),
  'password' => env('MAIL_PASSWORD'),
  'sendmail' => '/usr/sbin/sendmail -bs',
  'markdown' => [
      'theme' => 'default',

      'paths' => [
          resource_path('views/vendor/mail'),
      ],
  ],
];
