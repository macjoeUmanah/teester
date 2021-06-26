<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
  public function run()
  {
    DB::table('settings')->truncate();

    $attributes['top_left_html'] = '<img src="/storage/app/public/mc-logo.png">';
    $attributes['login_html'] = '<img src="/storage/app/public/mc-logo-m.png">';
    $attributes['login_image'] = '/storage/app/public/login_image.png';
    $attributes['cron_timestamp'] = '2019-08-30 17:00:05';
    DB::table('settings')->insert([
      'app_name' => 'MailCarry',
      'app_url' => 'http://example.com',
      'from_email' => 'admin@example.com',
      'current_version' => '2.5.2',
      'attributes' => json_encode($attributes),
    ]);
}
}
