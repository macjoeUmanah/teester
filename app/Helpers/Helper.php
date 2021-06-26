<?php

namespace App\Helpers;

class Helper
{

  /**
   * Retrun all timezones 
  */
  public static function timeZones($specific=null)
  {
    $timezones = [
      'Pacific/Midway'       => "(GMT-11:00) Midway Island",
      'US/Samoa'             => "(GMT-11:00) Samoa",
      'US/Hawaii'            => "(GMT-10:00) Hawaii",
      'US/Alaska'            => "(GMT-09:00) Alaska",
      'US/Pacific'           => "(GMT-08:00) Pacific Time (US & Canada)",
      'America/Tijuana'      => "(GMT-08:00) Tijuana",
      'US/Arizona'           => "(GMT-07:00) Arizona",
      'US/Mountain'          => "(GMT-07:00) Mountain Time (US & Canada)",
      'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
      'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
      'America/Mexico_City'  => "(GMT-06:00) Mexico City",
      'America/Monterrey'    => "(GMT-06:00) Monterrey",
      'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
      'US/Central'           => "(GMT-06:00) Central Time (US & Canada)",
      'US/Eastern'           => "(GMT-05:00) Eastern Time (US & Canada)",
      'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
      'America/Bogota'       => "(GMT-05:00) Bogota",
      'America/Lima'         => "(GMT-05:00) Lima",
      'America/Caracas'      => "(GMT-04:30) Caracas",
      'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
      'America/La_Paz'       => "(GMT-04:00) La Paz",
      'America/Santiago'     => "(GMT-04:00) Santiago",
      'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
      'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
      'Greenland'            => "(GMT-03:00) Greenland",
      'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
      'Atlantic/Azores'      => "(GMT-01:00) Azores",
      'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
      'Africa/Casablanca'    => "(GMT) Casablanca",
      'Europe/Dublin'        => "(GMT) Dublin",
      'Europe/Lisbon'        => "(GMT) Lisbon",
      'Europe/London'        => "(GMT) London",
      'Africa/Monrovia'      => "(GMT) Monrovia",
      'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
      'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
      'Europe/Berlin'        => "(GMT+01:00) Berlin",
      'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
      'Europe/Brussels'      => "(GMT+01:00) Brussels",
      'Europe/Budapest'      => "(GMT+01:00) Budapest",
      'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
      'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
      'Europe/Madrid'        => "(GMT+01:00) Madrid",
      'Europe/Paris'         => "(GMT+01:00) Paris",
      'Europe/Prague'        => "(GMT+01:00) Prague",
      'Europe/Rome'          => "(GMT+01:00) Rome",
      'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
      'Europe/Skopje'        => "(GMT+01:00) Skopje",
      'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
      'Europe/Vienna'        => "(GMT+01:00) Vienna",
      'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
      'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
      'Europe/Athens'        => "(GMT+02:00) Athens",
      'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
      'Africa/Cairo'         => "(GMT+02:00) Cairo",
      'Africa/Harare'        => "(GMT+02:00) Harare",
      'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
      'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
      'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
      'Europe/Kiev'          => "(GMT+02:00) Kyiv",
      'Europe/Minsk'         => "(GMT+02:00) Minsk",
      'Europe/Riga'          => "(GMT+02:00) Riga",
      'Europe/Sofia'         => "(GMT+02:00) Sofia",
      'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
      'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
      'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
      'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
      'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
      'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
      'Europe/Moscow'        => "(GMT+03:00) Moscow",
      'Asia/Tehran'          => "(GMT+03:30) Tehran",
      'Asia/Baku'            => "(GMT+04:00) Baku",
      'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
      'Asia/Muscat'          => "(GMT+04:00) Muscat",
      'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
      'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
      'Asia/Kabul'           => "(GMT+04:30) Kabul",
      'Asia/Karachi'         => "(GMT+05:00) Karachi",
      'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
      'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
      'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
      'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
      'Asia/Almaty'          => "(GMT+06:00) Almaty",
      'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
      'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
      'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
      'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
      'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
      'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
      'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
      'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
      'Australia/Perth'      => "(GMT+08:00) Perth",
      'Asia/Singapore'       => "(GMT+08:00) Singapore",
      'Asia/Taipei'          => "(GMT+08:00) Taipei",
      'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
      'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
      'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
      'Asia/Seoul'           => "(GMT+09:00) Seoul",
      'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
      'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
      'Australia/Darwin'     => "(GMT+09:30) Darwin",
      'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
      'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
      'Australia/Canberra'   => "(GMT+10:00) Canberra",
      'Pacific/Guam'         => "(GMT+10:00) Guam",
      'Australia/Hobart'     => "(GMT+10:00) Hobart",
      'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
      'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
      'Australia/Sydney'     => "(GMT+10:00) Sydney",
      'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
      'Asia/Magadan'         => "(GMT+12:00) Magadan",
      'Pacific/Auckland'     => "(GMT+12:00) Auckland",
      'Pacific/Fiji'         => "(GMT+12:00) Fiji",
    ];
    return !empty($specific) ? $timezones[$specific] : $timezones;
  }

  /**
   * Retrun timezones offset
  */
  public static function timeZonesOffset($timezone)
  {
    $timezones = [
      'Pacific/Midway'       => "-11:00",
      'US/Samoa'             => "-11:00",
      'US/Hawaii'            => "-10:00",
      'US/Alaska'            => "-09:00",
      'US/Pacific'           => "-08:00",
      'America/Tijuana'      => "-08:00",
      'US/Arizona'           => "-07:00",
      'US/Mountain'          => "-07:00",
      'America/Chihuahua'    => "-07:00",
      'America/Mazatlan'     => "-07:00",
      'America/Mexico_City'  => "-06:00",
      'America/Monterrey'    => "-06:00",
      'Canada/Saskatchewan'  => "-06:00",
      'US/Central'           => "-06:00",
      'US/Eastern'           => "-05:00",
      'US/East-Indiana'      => "-05:00",
      'America/Bogota'       => "-05:00",
      'America/Lima'         => "-05:00",
      'America/Caracas'      => "-04:30",
      'Canada/Atlantic'      => "-04:00",
      'America/La_Paz'       => "-04:00",
      'America/Santiago'     => "-04:00",
      'Canada/Newfoundland'  => "-03:30",
      'America/Buenos_Aires' => "-03:00",
      'Greenland'            => "-03:00",
      'Atlantic/Stanley'     => "-02:00",
      'Atlantic/Azores'      => "-01:00",
      'Atlantic/Cape_Verde'  => "-01:00",
      'Africa/Casablanca'    => "+00:00",
      'Europe/Dublin'        => "+00:00",
      'Europe/Lisbon'        => "+00:00",
      'Europe/London'        => "+00:00",
      'Africa/Monrovia'      => "+00:00",
      'Europe/Amsterdam'     => "+01:00",
      'Europe/Belgrade'      => "+01:00",
      'Europe/Berlin'        => "+01:00",
      'Europe/Bratislava'    => "+01:00",
      'Europe/Brussels'      => "+01:00",
      'Europe/Budapest'      => "+01:00",
      'Europe/Copenhagen'    => "+01:00",
      'Europe/Ljubljana'     => "+01:00",
      'Europe/Madrid'        => "+01:00",
      'Europe/Paris'         => "+01:00",
      'Europe/Prague'        => "+01:00",
      'Europe/Rome'          => "+01:00",
      'Europe/Sarajevo'      => "+01:00",
      'Europe/Skopje'        => "+01:00",
      'Europe/Stockholm'     => "+01:00",
      'Europe/Vienna'        => "+01:00",
      'Europe/Warsaw'        => "+01:00",
      'Europe/Zagreb'        => "+01:00",
      'Europe/Athens'        => "+02:00",
      'Europe/Bucharest'     => "+02:00",
      'Africa/Cairo'         => "+02:00",
      'Africa/Harare'        => "+02:00",
      'Europe/Helsinki'      => "+02:00",
      'Europe/Istanbul'      => "+02:00",
      'Asia/Jerusalem'       => "+02:00",
      'Europe/Kiev'          => "+02:00",
      'Europe/Minsk'         => "+02:00",
      'Europe/Riga'          => "+02:00",
      'Europe/Sofia'         => "+02:00",
      'Europe/Tallinn'       => "+02:00",
      'Europe/Vilnius'       => "+02:00",
      'Asia/Baghdad'         => "+03:00",
      'Asia/Kuwait'          => "+03:00",
      'Africa/Nairobi'       => "+03:00",
      'Asia/Riyadh'          => "+03:00",
      'Europe/Moscow'        => "+03:00",
      'Asia/Tehran'          => "+03:30",
      'Asia/Baku'            => "+04:00",
      'Europe/Volgograd'     => "+04:00",
      'Asia/Muscat'          => "+04:00",
      'Asia/Tbilisi'         => "+04:00",
      'Asia/Yerevan'         => "+04:00",
      'Asia/Kabul'           => "+04:30",
      'Asia/Karachi'         => "+05:00",
      'Asia/Tashkent'        => "+05:00",
      'Asia/Kolkata'         => "+05:30",
      'Asia/Kathmandu'       => "+05:45",
      'Asia/Yekaterinburg'   => "+06:00",
      'Asia/Almaty'          => "+06:00",
      'Asia/Dhaka'           => "+06:00",
      'Asia/Novosibirsk'     => "+07:00",
      'Asia/Bangkok'         => "+07:00",
      'Asia/Jakarta'         => "+07:00",
      'Asia/Krasnoyarsk'     => "+08:00",
      'Asia/Chongqing'       => "+08:00",
      'Asia/Hong_Kong'       => "+08:00",
      'Asia/Kuala_Lumpur'    => "+08:00",
      'Australia/Perth'      => "+08:00",
      'Asia/Singapore'       => "+08:00",
      'Asia/Taipei'          => "+08:00",
      'Asia/Ulaanbaatar'     => "+08:00",
      'Asia/Urumqi'          => "+08:00",
      'Asia/Irkutsk'         => "+09:00",
      'Asia/Seoul'           => "+09:00",
      'Asia/Tokyo'           => "+09:00",
      'Australia/Adelaide'   => "+09:30",
      'Australia/Darwin'     => "+09:30",
      'Asia/Yakutsk'         => "+10:00",
      'Australia/Brisbane'   => "+10:00",
      'Australia/Canberra'   => "+10:00",
      'Pacific/Guam'         => "+10:00",
      'Australia/Hobart'     => "+10:00",
      'Australia/Melbourne'  => "+10:00",
      'Pacific/Port_Moresby' => "+10:00",
      'Australia/Sydney'     => "+10:00",
      'Asia/Vladivostok'     => "+11:00",
      'Asia/Magadan'         => "+12:00",
      'Pacific/Auckland'     => "+12:00",
      'Pacific/Fiji'         => "+12:00",
    ];
    return $timezones[$timezone];
  }

  /**
   * Retrun app bouce rules
  */
  public static function bouceCodes($code=null)
  {
    $bouce_codes = [
      '520' => ['type' => 'Soft', 'description' => 'Other or undefined mailbox status'],
      '521' => ['type' => 'Soft', 'description' => 'Mailbox disabled, not accepting messages'],
      '522' => ['type' => 'Soft', 'description' => 'Mailbox full'],
      '531' => ['type' => 'Soft', 'description' => 'Mail system full'],
      '545' => ['type' => 'Soft', 'description' => 'Network congestion'],
      '553' => ['type' => 'Soft', 'description' => 'Too many recipients'],
      '500' => ['type' => 'Hard', 'description' => 'Address does not exist'],
      '510' => ['type' => 'Hard', 'description' => 'Other address status'],
      '511' => ['type' => 'Hard', 'description' => 'Bad destination mailbox address'],
      '512' => ['type' => 'Hard', 'description' => 'Bad destination system address'],
      '513' => ['type' => 'Hard', 'description' => 'Bad destination mailbox address syntax'],
      '514' => ['type' => 'Hard', 'description' => 'Destination mailbox address ambiguous'],
      '515' => ['type' => 'Hard', 'description' => 'Destination mailbox address valid'],
      '516' => ['type' => 'Hard', 'description' => 'Mailbox has moved'],
      '517' => ['type' => 'Hard', 'description' => 'Bad sender\’s mailbox address syntax'],
      '518' => ['type' => 'Hard', 'description' => 'Bad sender’s system address'],
      '523' => ['type' => 'Hard', 'description' => 'Message length exceeds administrative limit.'],
      '524' => ['type' => 'Hard', 'description' => 'Mailing list expansion problem'],
      '530' => ['type' => 'Hard', 'description' => 'Other or undefined mail system status'],
      '532' => ['type' => 'Hard', 'description' => 'System not accepting network messages'],
      '533' => ['type' => 'Hard', 'description' => 'System not capable of selected features'],
      '534' => ['type' => 'Hard', 'description' => 'Message too big for system'],
      '540' => ['type' => 'Hard', 'description' => 'Other or undefined network or routing status'],
      '541' => ['type' => 'Hard', 'description' => 'No answer from host'],
      '542' => ['type' => 'Hard', 'description' => 'Bad connection'],
      '543' => ['type' => 'Hard', 'description' => 'Routing server failure'],
      '544' => ['type' => 'Hard', 'description' => 'Unable to route'],
      '546' => ['type' => 'Hard', 'description' => 'Routing loop detected'],
      '547' => ['type' => 'Hard', 'description' => 'Delivery time expired'],
      '550' => ['type' => 'Hard', 'description' => 'Address does not exist'],
      '551' => ['type' => 'Hard', 'description' => 'Invalid command'],
      '552' => ['type' => 'Hard', 'description' => 'Syntax error'],
      '554' => ['type' => 'Hard', 'description' => 'Invalid command arguments'],
      '555' => ['type' => 'Hard', 'description' => 'Wrong protocol version'],
      '560' => ['type' => 'Hard', 'description' => 'Other or undefined media error'],
      '561' => ['type' => 'Hard', 'description' => 'Media not supported'],
      '562' => ['type' => 'Hard', 'description' => 'Conversion required and prohibited'],
      '563' => ['type' => 'Hard', 'description' => 'Conversion required but not supported'],
      '564' => ['type' => 'Hard', 'description' => 'Conversion with loss performed'],
      '565' => ['type' => 'Hard', 'description' => ' Conversion failed'],
      '570' => ['type' => 'Hard', 'description' => 'Other or undefined security status'],
      '571' => ['type' => 'Hard', 'description' => 'Delivery not authorized, message refused'],
      '572' => ['type' => 'Hard', 'description' => 'Mailing list expansion prohibited'],
      '573' => ['type' => 'Hard', 'description' => 'Security conversion required but not possible'],
      '574' => ['type' => 'Hard', 'description' => 'Security features not supported'],
      '575' => ['type' => 'Hard', 'description' => 'Cryptographic failure'],
      '576' => ['type' => 'Hard', 'description' => 'Cryptographic algorithm not supported'],
      '577' => ['type' => 'Hard', 'description' => 'Message integrity failure'],
      '605' => ['type' => 'Hard', 'description' => 'Not delivering to previously bounced address'],
      '911' => ['type' => 'Hard', 'description' => 'Hard bounce with no bounce code found. It could be an invalid email or rejected email from your mail server (such as from a sending limit).'],
      '5.2.0' => ['type' => 'Soft', 'description' => 'Other or undefined mailbox status'],
      '5.2.1' => ['type' => 'Soft', 'description' => 'Mailbox disabled, not accepting messages'],
      '5.2.2' => ['type' => 'Soft', 'description' => 'Mailbox full'],
      '5.3.1' => ['type' => 'Soft', 'description' => 'Mail system full'],
      '5.4.5' => ['type' => 'Soft', 'description' => 'Network congestion'],
      '5.5.3' => ['type' => 'Soft', 'description' => 'Too many recipients'],
      '5.0.0' => ['type' => 'Hard', 'description' => 'Address does not exist'],
      '5.1.0' => ['type' => 'Hard', 'description' => 'Other address status'],
      '5.1.1' => ['type' => 'Hard', 'description' => 'Bad destination mailbox address'],
      '5.1.2' => ['type' => 'Hard', 'description' => 'Bad destination system address'],
      '5.1.3' => ['type' => 'Hard', 'description' => 'Bad destination mailbox address syntax'],
      '5.1.4' => ['type' => 'Hard', 'description' => 'Destination mailbox address ambiguous'],
      '5.1.5' => ['type' => 'Hard', 'description' => 'Destination mailbox address valid'],
      '5.1.6' => ['type' => 'Hard', 'description' => 'Mailbox has moved'],
      '5.1.7' => ['type' => 'Hard', 'description' => 'Bad sender\’s mailbox address syntax'],
      '5.1.8' => ['type' => 'Hard', 'description' => 'Bad sender’s system address'],
      '5.2.3' => ['type' => 'Hard', 'description' => 'Message length exceeds administrative limit.'],
      '5.2.4' => ['type' => 'Hard', 'description' => 'Mailing list expansion problem'],
      '5.3.0' => ['type' => 'Hard', 'description' => 'Other or undefined mail system status'],
      '5.3.2' => ['type' => 'Hard', 'description' => 'System not accepting network messages'],
      '5.3.3' => ['type' => 'Hard', 'description' => 'System not capable of selected features'],
      '5.3.4' => ['type' => 'Hard', 'description' => 'Message too big for system'],
      '5.4.0' => ['type' => 'Hard', 'description' => 'Other or undefined network or routing status'],
      '5.4.1' => ['type' => 'Hard', 'description' => 'No answer from host'],
      '5.4.2' => ['type' => 'Hard', 'description' => 'Bad connection'],
      '5.4.3' => ['type' => 'Hard', 'description' => 'Routing server failure'],
      '5.4.4' => ['type' => 'Hard', 'description' => 'Unable to route'],
      '5.4.6' => ['type' => 'Hard', 'description' => 'Routing loop detected'],
      '5.4.7' => ['type' => 'Hard', 'description' => 'Delivery time expired'],
      '5.5.0' => ['type' => 'Hard', 'description' => 'Address does not exist'],
      '5.5.1' => ['type' => 'Hard', 'description' => 'Invalid command'],
      '5.5.2' => ['type' => 'Hard', 'description' => 'Syntax error'],
      '5.5.4' => ['type' => 'Hard', 'description' => 'Invalid command arguments'],
      '5.5.5' => ['type' => 'Hard', 'description' => 'Wrong protocol version'],
      '5.6.0' => ['type' => 'Hard', 'description' => 'Other or undefined media error'],
      '5.6.1' => ['type' => 'Hard', 'description' => 'Media not supported'],
      '5.6.2' => ['type' => 'Hard', 'description' => 'Conversion required and prohibited'],
      '5.6.3' => ['type' => 'Hard', 'description' => 'Conversion required but not supported'],
      '5.6.4' => ['type' => 'Hard', 'description' => 'Conversion with loss performed'],
      '5.6.5' => ['type' => 'Hard', 'description' => ' Conversion failed'],
      '5.7.0' => ['type' => 'Hard', 'description' => 'Other or undefined security status'],
      '5.7.1' => ['type' => 'Hard', 'description' => 'Delivery not authorized, message refused'],
      '5.7.2' => ['type' => 'Hard', 'description' => 'Mailing list expansion prohibited'],
      '5.7.3' => ['type' => 'Hard', 'description' => 'Security conversion required but not possible'],
      '5.7.4' => ['type' => 'Hard', 'description' => 'Security features not supported'],
      '5.7.5' => ['type' => 'Hard', 'description' => 'Cryptographic failure'],
      '5.7.6' => ['type' => 'Hard', 'description' => 'Cryptographic algorithm not supported'],
      '5.7.7' => ['type' => 'Hard', 'description' => 'Message integrity failure'],
      '9.1.1' => ['type' => 'Hard', 'description' => 'Hard bounce with no bounce code found. It could be an invalid email or rejected email from your mail server (such as from a sending limit).'],
    ];
    if(!empty($code)) {
      return (array_key_exists($code, $bouce_codes)) ? $bouce_codes[$code] : null;
    } else {
      return $bouce_codes;;
    }
  }

  /**
   * Retrun all supported languages
  */
  public static function languages($language=null)
  {
    $languages = [
      'en' => 'English',
      'fr' => 'French',
      'de' => 'German',
      'es' => 'Español'
    ];

    if(!empty($language)) {
      return $languages[$language];
    }
    return $languages;
  }

  /**
   * Retrun all countries
  */
  public static function countries($country_code=null)
  {
    $countries = \DB::table('countries')->pluck('name', 'code'); // get countries;

    return !empty($country_code) ? $countries[$country_code] : $countries;
  }

  /**
   * Retrun all permissions
  */
  public static function mcPermissions()
  {
    return [ 
      [
        'title' => __('app.user_management'),
        'modules' => [
          [
            'title' => __('app.lists'),
            'permissions' => [
              'lists' => __('app.add_new_list') . ' / '. __('app.view_manage'),
              'custom_fields' => __('app.custom_fields'),
              'export_contacts' => __('app.export_contacts'),
              'split' => __('app.list_split'),
              'bulk_update' => __('app.bulk_update'),
              'email_verifiers' => __('app.email_verifiers'),
              'suppression' => __('app.setup_suppression'),
            ]
          ],
          [
            'title' => __('app.contacts'),
            'permissions' => [
              'contacts' => __('app.add_new_contact') . ' / '. __('app.view_manage'),
              'import_contacts' => __('app.import_contacts'),
            ]
          ],
          [
            'title' => __('app.campaigns'),
            'permissions' => [
              'broadcasts' => __('app.create_new') . ' / '. __('app.view_manage'),
              'campaigns' => __('app.campaign') . ' ' . __('app.schedules'),
            ]
          ],
          [
            'title' => __('app.automation'),
            'permissions' => [
              'spintags' => __('app.automation_spintags'),
              'segments' => __('app.automation_segments'),
              'drips' => __('app.drips'),
              'triggers' => __('app.triggers'),
            ]
          ],
          [
            'title' => __('app.setup'),
            'permissions' => [
              'sending_domains' => __('app.setup_sending_domains'),
              'sending_servers' => __('app.setup_sending_servers'),
              'pmta' => __('app.setup_pmta'),
              'bounces' => __('app.setup_bounces'),
              'bounces' => __('app.setup_bounces'),
              'fbl' => __('app.setup_fbl')
            ]
          ],
          [
            'title' => __('app.settings'),
            'permissions' => [
              'settings_api' => __('app.settings_api'),
              'settings_mail_headers' => __('app.settings_mail_headers'),
            ]
          ],
          [
            'title' => __('app.layouts'),
            'permissions' => [
              'web_forms' => __('app.setup_webforms'),
              'templates' => __('app.templates'),
              'pages' => __('app.pages_emails'),
            ]
          ],
          [
            'title' => __('app.stats'),
            'permissions' => [
              'stats_campaigns' => __('app.campaigns'),
              'stats_triggers' => __('app.triggers'),
            ]
          ],
          [
            'title' => __('app.blacklisted'),
            'permissions' => [
              'blacklisted_ips' => __('app.ips'),
              'blacklisted_domains' => __('app.domains'),
              'global_bounced' => __('app.global_bounced'),
              'global_spam' => __('app.global_spam'),
            ]
          ],
          [
            'title' => __('app.user_management'),
            'permissions' => [
              'roles' => __('app.roles'),
              'users' => __('app.users')
            ]
          ],
          [
            'title' => __('app.tools'),
            'permissions' => [
              'image_manager' => __('app.tools_images_manager'),
              'logs' => __('app.tools_logs'),
            ]
          ],
        ]
      ]
    ];
  }

  /**
   * Verify a permission to the user
  */
  public static function checkPermissions($permission)
  {
    if(!\Auth::user()->can($permission)) {
     return abort(403);
   }
 }

  /*
   * Replace regular expression changing multiple spaces or hyphens with one hyphen:
  */
  public static function replaceHyphen($str)
  {
    return preg_replace('#[ -]+#', '-', $str);
  }

  /**
   * Retrun datetiem format for the app
  */
  public static function datetimeDisplay($datetime, $time_zone = null)
  {
    $carbon = new \Carbon\Carbon($datetime);
    if(!empty($time_zone))
      $carbon->setTimezone($time_zone);
    else
      $carbon->setTimezone(\Auth::user()->time_zone);
    $datetime = $carbon->format('M d, Y h:i:s A');
    return $datetime;
  }

  /**
   * Retrun limited data after filtration for datatables
  */
  public static function dataFilters($request, $result, $columns)
  {

    // If there is a search
    $keywords = $request->get('search')['value'];
    if ($keywords != "") {
      $result->Where(function($query) use ($keywords, $columns) {
        foreach($columns as $column) {
          $query->orWhere($column, 'LIKE', "%{$keywords}%");
        }
      });
    }

    $total = $result->count();

    // For orders by
    foreach($request->get('order') as $order) {
      $result->orderBy($columns[$order['column']], $order['dir']);
    }

    $offset = $request->get('start');
    $limit = $request->get('length');
    $result->offset($offset)->limit($limit);

    $data = [
      'total' => $total,
      'result' => $result
    ];

    return $data;
  }

  /**
   * Retrun limited data after filtration for datatables
  */
  public static function datatableTotals($total) {
    return [
      "iTotalRecords" => $total,
      "iTotalDisplayRecords" => $total,
      "data" => []
    ];
  }

  /**
   * Retrun value after split for linebreak
  */
  public static function splitLineBreak($value)
  {
    return preg_split('/\r\n|[\r\n]/', $value);
  }

  /**
   * Retrun value after split for linebreak and comma
  */
  public static function splitLineBreakWithComma($value)
  {
    return preg_split('/\r\n|[\r\n ,]+/', $value);
  }

  /**
   * Retrun date in db format
  */
  public static function dbDate($date) {
    return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
  }

  /**
   * Create directory if not exist
  */
  public static function dirCreateOrExist($dir)
  {
   if(!is_dir($dir)) {
    if(!mkdir($dir, 0777, true)) {
      throw new Exception("Dir not created", 1);
    }
  }
}

  /**
   * Retrun .csv file headers
  */
  public static function getCsvFileHeader($file)
  {
    $csv = \League\Csv\Reader::createFromPath($file, 'r');
    $csv->setHeaderOffset(0);
    return $csv->getHeader();
  }

  /**
   * Retrun .csv file counts
  */
  public static function getCsvCount($file)
  {
    $csv = \League\Csv\Reader::createFromPath($file, 'r');
    return count($csv);
  }

  /**
   * Retrun dropdown for system shortcodes
  */
  public static function dropdownCustom($title, $data, $func)
  {
    $dropdown = '';
    $dropdown .= '<div class="btn-group">
    <button type="button" class="btn btn-primary btn-xs">'.$title.'</button>
    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">';
    foreach($data as $key => $val) {
      $dropdown .= "<li><a href='javascript:;' onclick=\"{$func}('$key');\">$val</a></li>";
    }
    $dropdown .= '</ul>
    </div>';
    return $dropdown;
  }

  /**
   * Retrun system variables
  */
  public static function systemVariables()
  {
    return [
      'list-id' => 'List ID',
      'list-name' => 'List Name',
      'broadcast-id' => 'Broadcast ID',
      'broadcast-name' => 'Broadcast Name',
      'sender-name' => 'Sender Name',
      'sender-email' => 'Sender Email',
      'receiver-email' => 'Receiver Email',
      'confirm-link' => 'Confirmation Link',
      'unsub-link' => 'Unsubscribe Link',
      'todays-date' => 'Todays Date',
      'message-id' => 'Message-ID',
      'contact-id' => 'Contact-ID'
    ];
  }

  /**
   * Retrun app shortcodes
  */
  public static function shortcodes($section='all')
  {
    $shortcodes = '';
    $shortcodes .= 
    '<div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">'.__('app.shortcodes').'</h4>
    </div>
    <div class="modal-body"><div class="row">';
    
    if($section == 'all') {
      $shortcodes .= Helper::shortcodesSystemVariables();
    }
    if($section == 'all') {
      $shortcodes .= Helper::shortcodesCustomFields();
    }
    if($section == 'all' || $section == 'spintags') {
      $shortcodes .= Helper::shortcodesSpintags();
    }

    $shortcodes .= '</div></div>';

    $shortcodes .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">'.__('app.close').'</button></div>';

    $shortcodes .= '</div>';

    return $shortcodes;
  }

  /**
   * Retrun custom fields shortcodes
  */
  public static function shortcodesSystemVariables()
  {
    $system_variables = Helper::systemVariables();
    $shortcodes = '<div class="col-md-12 text-bold" style="padding-top:5px;">'.__('app.system_variables').'</div>';
    foreach($system_variables as $key => $val) {
      $shortcode = "[\${$key}$]";
      $shortcodes .= "<div class='col-md-3'  style='padding-bottom: 5px; padding-top:5px;'><button class='btn btn-default btn-xs btn-block' onclick=\"systemVariables('$shortcode');\" title='".__('app.click_to_insert_tag')." [\${$key}$]'>$val <br> [\${$key}$]</div>";
    }
    return $shortcodes;
  }

  /**
   * Retrun custom fields shortcodes
  */
  public static function shortcodesCustomFields()
  {
    $custom_fields = \App\Models\CustomField::whereAppId(\Auth::user()->app_id)->pluck('name', 'tag');
    $shortcodes = '<div class="col-md-12 text-bold" style="padding-top:20px;">'.__('app.custom_fields').'</div>';
    if(count($custom_fields) > 0) {
      foreach($custom_fields as $key => $val) {
        $shortcode = "[#{$key}#]";
        $shortcodes .= "<div class='col-md-3'  style='padding-bottom: 5px; padding-top:5px;'><button class='btn btn-default btn-xs btn-block' onclick=\"customFields('$shortcode');\" title='".__('app.click_to_insert_tag')." [#{$key}#]'>$val <br> [#{$key}#]</div>";
      }
    } else {
      $shortcodes .= "<div class='col-md-12'>".__('app.no_record_found')."</div>";
    }
    return $shortcodes;
  }

  /**
   * Retrun spintag shortcodes
  */
  public static function shortcodesSpintags()
  {
    $spintags = \App\Models\Spintag::whereAppId(\Auth::user()->app_id)->pluck('name', 'tag');
    $shortcodes = '<div class="col-md-12 text-bold" style="padding-top:20px;">'.__('app.automation_spintags').'</div>';
    if(count($spintags) > 0) {
      foreach($spintags as $key => $val) {
        $shortcode = "[%{$key}%]";
        $shortcodes .= "<div class='col-md-3'  style='padding-bottom: 5px; padding-top:5px;'><button class='btn btn-default btn-xs btn-block' onclick=\"spinTags('$shortcode');\" title='".__('app.click_to_insert_tag')." [%{$key}%]'>$val <br> [%{$key}%]</div>";
      }
    } else {
      $shortcodes .= "<div class='col-md-12'>".__('app.no_record_found')."</div>";
    }
    return $shortcodes;
  }

  /**
   * Retrun public and private key with 1024 bits
  */
  public static function generateKeys()
  {
    try {
      $key_pair = openssl_pkey_new([
        'digest_alg'       => 'sha1',
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
      ]);
      openssl_pkey_export($key_pair, $private_key);
      $detail = openssl_pkey_get_details($key_pair);
      $public_key = trim(preg_replace('/\s+/', '', $detail['key'])); // remove space etc if exist
      //$public_key = "v=DKIM1; k=rsa; p=" . $public_key;
    } catch (\Exception $e) {
      $private_key = $public_key = 'None';
    }
    $keys = [
      'private_key' => $private_key,
      'public_key' => $public_key
    ];
    return $keys;
  }

  /**
   * Retrun the email verifiers that supported by the app
  */
  public static function emailVerifiers($name = null)
  {
    $email_verifiers = [
      'kickbox' => 'Kickbox',
      'emailoversight' => 'EmailOversight',
      'neverbounce' => 'NeverBounce',
      'bulkemailchecker' => 'BulkEmailChecker',
      'sendgrid' => 'SendGrid',
      'mailgun' => 'Mailgun',
    ];

    return empty($name) ? $email_verifiers : $email_verifiers[$name];
  }

  /**
   * Retrun the sending servers that supported by the app
  */
  public static function sendingServers($name = null)
  {
    $sending_servers = [
      'php_mail' => 'PHP Mail',
      'smtp' => 'SMTP',
      'amazon_ses_api' => 'Amazon SES API',
      'mailgun_api' => 'Mailgun API',
      'sparkpost_api' => 'SparkPost API',
      'sendgrid_api' => 'SendGrid API',
      'mandrill_api' => 'Mandrill API',
      'elastic_email_api' => 'Elastic Email API',
      'mailjet_api' => 'MailJet API',
      'sendinblue_api' => 'SendinBlue API',
    ];

    return empty($name) ? $sending_servers : $sending_servers[$name];
  }


  /**
   * Retrun app supported sending servers that supported by the framework
  */
  public static function sendingServersFramworkSuported()
  {
    return [
      'php_mail',
      'smtp',
      'amazon_ses_api',
      'mailgun_api',
      'sparkpost_api',
      'mandrill_api',
      'elastic_email_api',
      'mailjet_api',
      'sendinblue_api'
    ];
  }

  /**
   * Check sending server limit and return data can be use for update
  */
  public static function checkSendingServerLimit($speed_attributes, $hourly_sent, $daily_sent)
  {
    $sending_server_paused = false;
    $data = null;
    $speed_attributes = json_decode($speed_attributes);
    if($speed_attributes->speed == 'Limited') {
      if($speed_attributes->duration == 'hourly') {
        if($hourly_sent >= $speed_attributes->limit) {
          $data['status'] = 'System Paused';
          $data['hourly_sent_next_timestamp'] = \Carbon\Carbon::now()->addHour(1);
          $data['notification'] = __('app.msg_hourly_limit');
          $sending_server_paused = true;
        }
      } elseif($speed_attributes->duration == 'daily') {
        if($daily_sent >= $speed_attributes->limit) {
          $data['status'] = 'System Paused';
          $data['daily_sent_next_timestamp'] = \Carbon\Carbon::now()->addDay(1);
          $data['notification'] = __('app.msg_daily_limit');
          $sending_server_paused = true;
        }
      }
    }
    return [
      'data' => $data,
      'sending_server_paused' => $sending_server_paused
    ];
  }

  /**
   * Update sending server limits counters and return array
  */
  public static function updateSendingServerCounters($id)
  {
    $sending_server = \App\Models\SendingServer::findOrFail($id);

    // Update sending server data
    $sending_server_data['total_sent']  = $sending_server->total_sent+1;
    $sending_server_data['hourly_sent'] = $sending_server->hourly_sent+1;
    $sending_server_data['daily_sent']  = $sending_server->daily_sent+1;

    $sending_server_additional_data = Helper::checkSendingServerLimit($sending_server->speed_attributes, $sending_server_data['hourly_sent'], $sending_server_data['daily_sent']);


    if(!empty($sending_server_additional_data['data'])) {
      $sending_server_data = array_merge($sending_server_data, $sending_server_additional_data['data']);
    }

    // Need to update server servers counters and data, after succcessful sent
    \App\Models\SendingServer::whereId($sending_server->id)->update($sending_server_data);

    $sending_server_data['sending_server_paused'] = $sending_server_additional_data['sending_server_paused'];

    return $sending_server_data;
  }

  /**
   * Retrun amazon regions
  */
  public static function amazonRegions()
  {
    return [
      'us-east-2' => 'US East (Ohio)',
      'us-east-1' => 'US East (N. Virginia)',
      'us-west-1' => 'US West (N. California)',
      'us-west-2' => 'US West (Oregon)',
      'ap-south-1' => 'Asia Pacific (Mumbai)',
      'ap-northeast-3' => 'Asia Pacific (Osaka-Local)',
      'ap-northeast-2' => 'Asia Pacific (Seoul)',
      'ap-southeast-1' => 'Asia Pacific (Singapore)',
      'ap-southeast-2' => 'Asia Pacific (Sydney)',
      'ap-northeast-1' => 'Asia Pacific (Tokyo)',
      'ca-central-1' => 'Canada (Central)',
      'cn-north-1' => 'China (Beijing)',
      'cn-northwest-1' => 'China (Ningxia)',
      'eu-central-1' => 'EU (Frankfurt)',
      'eu-west-1' => 'EU (Ireland)',
      'eu-west-2' => 'EU (London)',
      'eu-west-3' => 'EU (Paris)',
      'eu-north-1' => 'EU (Stockholm)',
      'sa-east-1' => 'South America (São Paulo)',
    ];
  }

  /**
   * Retrun app url
   * @param boolean
  */
  public static function getAppURL($without_protocol=null)
  {
    $app_url = \DB::table('settings')->where('id', config('mc.app_id'))->value('app_url');
    return $without_protocol ? parse_url($app_url, PHP_URL_HOST) : $app_url;
  }

  /**
   * Retrun Message-ID
  */
  public static function getCustomMessageID($domain = null)
  { 
    $domain = empty($domain) ? \Helper::getAppURL() : $domain;
    $domain = str_replace('www.', '', $domain); // Remove www for url if any
    return sprintf('%s@%s', md5(\Helper::uniqueID()), parse_url($domain, PHP_URL_HOST));
  }

  /**
   * Retrun Sending Domain with protocole extract from from_email
  */
  public static function getSendingDomainFromEmail($from_email)
  {
    $domain = explode('@', $from_email)[1];
    return \DB::table('sending_domains')->whereDomain($domain)->first();
  }

  /**
   * Retrun Unique-ID
  */
  public static function uniqueID()
  {
    return uniqid(time());
  } 

  /**
   * Retrun status after try to connect with sending server
  */
  public static function configureSendingNode($type, $attributes, $message_id=null)
  {
    $msg = 'success';
    $success = true;
    $sending_attributes = json_decode($attributes, true);
    if($type == 'php_mail') {
      try{
       $transport = new \Swift_SendmailTransport();
     } catch(\Exception $e) {
      $message = explode('[', $e->getMessage());
      $msg = $message[0];
      $success = false;
      \Log::error('helper:configureSendingNode:php-mail => '.$e->getMessage());
    }
  } elseif($type == 'smtp') {
    $sending_attributes['encryption'] = $sending_attributes['encryption'] != 'none' ? $sending_attributes['encryption'] : '';
    try {
      $transport = new \Swift_SmtpTransport(
        $sending_attributes['host'],
        $sending_attributes['port'],
        $sending_attributes['encryption']
      );

      if($sending_attributes['encryption'] == 'ssl' || $sending_attributes['encryption'] == 'tls') {
        $transport->setStreamOptions([
          'ssl' => ['allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false]
        ]);
      }
      $transport->setUsername($sending_attributes['username']);
      $transport->setPassword(\Crypt::decrypt($sending_attributes['password']));



      $mailer = new \Swift_Mailer($transport);
      $mailer->getTransport()->start();
    } catch (\Exception $e) {
      $message = explode('[', $e->getMessage());
      $msg = $message[0];
      $success = false;
      \Log::error('helper:configureSendingNode:smtp => '.$e->getMessage());
    }
  } elseif($type == 'sparkpost_api') {
    $transport = new \Illuminate\Mail\Transport\SparkPostTransport(
      new \GuzzleHttp\Client(),
      \Crypt::decrypt($sending_attributes['api_key'])
    );
  } elseif($type == 'mailgun_api') {
    $transport = new \Illuminate\Mail\Transport\MailgunTransport(
      new \GuzzleHttp\Client(), 
      \Crypt::decrypt($sending_attributes['api_key']),
      $sending_attributes['domain']
    );
  } elseif($type == 'mandrill_api') {
    $transport = new \Illuminate\Mail\Transport\MandrillTransport(
      new \GuzzleHttp\Client(), 
      \Crypt::decrypt($sending_attributes['api_key'])
    );
  } elseif($type == 'amazon_ses_api') {
    $config = [
      'credentials' => [
        'key'    => $sending_attributes['access_key'],
        'secret' => \Crypt::decrypt($sending_attributes['secret_key']),
      ],
      'region' => $sending_attributes['region'],   
      'version' => 'latest',
      'service' => 'email'
    ];
    $transport = new \Illuminate\Mail\Transport\SesTransport(
      new \Aws\Ses\SesClient($config)
    );
  } elseif($type == 'elastic_email_api') {
    // message_id will be use as customid to track bounce/spam etc.
    $transport = new \Chocoholics\LaravelElasticEmail\ElasticTransport(
      new \GuzzleHttp\Client(), 
      \Crypt::decrypt($sending_attributes['api_key']),
      $sending_attributes['account_id'],
      $message_id
    );
  } elseif($type == 'mailjet_api') {
    // message_id will be use as customid to track bounce/spam etc.
    $transport = new \MailjetLaravelDriver\MailJetTransport(
      $sending_attributes['api_key'],
      \Crypt::decrypt($sending_attributes['secret_key']),
      $message_id
    );
  } elseif($type == 'sendinblue_api') {
    $transport = new \Webup\LaravelSendinBlue\SendinBlueTransport(
      new \SendinBlue\Client\Api\SMTPApi(
        new \GuzzleHttp\Client(),
        \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey("api-key", \Crypt::decrypt($sending_attributes['api_key']))
      )
    );
  } else {
    $transport = 'No built-in transport.';
  }

  return [
    'transport' => $transport,
    'success' => $success,
    'msg' => $msg
  ];
}

  /**
   * Retrun basic configuration for sending an email
  */
  public static function configureEmailBasicSettings($sending_server)
  {
    if($sending_server->type == 'sendgrid_api') {
      $message = new \SendGrid\Mail\Mail();
      $message->setFrom($sending_server->from_email, Helper::decodeString($sending_server->from_name));
      !empty($sending_server->reply_email) ? $message->setReplyTo($sending_server->reply_email) : '';
      return $message;
    } else {
      $message = new \Swift_Message();
      $message->setFrom($sending_server->from_email, Helper::decodeString($sending_server->from_name));
      !empty($sending_server->reply_email) ? $message->addReplyTo($sending_server->reply_email) : '';
      !empty($sending_server->bounce->email) ? $message->setReturnPath($sending_server->bounce->email) : '';
      $sending_domain = Helper::getSendingDomainFromEmail($sending_server->from_email);
      $body_encoding = json_decode($sending_server->sending_attributes)->body_encoding ?? null;
      if(!empty($body_encoding) && $body_encoding == 'base64') {
        $message->setEncoder(new \Swift_Mime_ContentEncoder_Base64ContentEncoder());
      } elseif(!empty($body_encoding) && $body_encoding == '7-bit') {
        $message->setEncoder(new \Swift_Mime_ContentEncoder_PlainContentEncoder('7bit'));
      } else {
        // quoted-printable default
        $message->setEncoder(new \Swift_Mime_ContentEncoder_NativeQpContentEncoder());
      }
      return $message->setId(\Helper::getCustomMessageID($sending_domain->protocol.$sending_domain->domain));
    }
  }

  /**
   * Attach dkim sign
  */
  public static function attachSigner($message, $privateKey, $sending_domain, $selector)
  {
    return $message->attachSigner((new \Swift_Signers_DKIMSigner($privateKey, $sending_domain, $selector))
      ->setBodyCanon('simple')
      ->ignoreHeader('Return-Path')
      ->setHeaderCanon('relaxed')
      ->setHashAlgorithm('rsa-sha1')
    );
  }

  /**
   * Retrun percentage
  */
  public static function getPercnetage($processed, $total)
  {
    $total = !empty($total) ? $total : 1; // avoid to divid with zero
    return round(($processed * 100) / $total, 2) . ' %';
  }

  /**
   * Retrun strintg after replace the system variables shortcodes
  */
  public static function replaceSystemVariables($contact, $data, $data_values)
  {
    $system_variables = Helper::systemVariables();
    $system_variables_shortcodes = [];
    foreach($system_variables as $key => $val) {
     array_push($system_variables_shortcodes, "[\${$key}$]");
   }

   $data_values['contact-id'] = $contact->id;

   $list_id = !empty($contact->list_id) ? $contact->list_id : '';
   $list_name = !empty($contact->list->name) ? $contact->list->name : '';
   $receiver_email = !empty($contact->email) ? $contact->email : '';
   $broadcast_id = !empty($data_values['broadcast-id']) ? $data_values['broadcast-id'] : '';
   $broadcast_name = !empty($data_values['broadcast-name']) ? $data_values['broadcast-name'] : '';
   $sender_name = !empty($data_values['sender-name']) ? $data_values['sender-name'] : '';
   $sender_email = !empty($data_values['sender-email']) ? $data_values['sender-email'] : '';
   $message_id = !empty($data_values['message-id']) ? $data_values['message-id'] : '';
   $todays_date = date("F j, Y");
   $contact_id = !empty($data_values['contact-id']) ? $data_values['contact-id'] : '';

   // $data_values['confirm-link-id'] = 1;

   $unsbu_link = $confirm_link = '';
   $domain = !empty($data_values['domain']) ? $data_values['domain'] : \Helper::getAppURL();
   if(!empty($contact->id)) {
    $confirm_link = $domain . '/contact/confirm/' . base64_encode($contact->id);
    $unsbu_link = $domain . '/contact/unsub/' . base64_encode($contact->id);
  }

  $system_variables_shortcodes_values = [
    $list_id,
    $list_name,
    $broadcast_id,
    $broadcast_name,
    $sender_name,
    $sender_email,
    $receiver_email,
    $confirm_link,
    $unsbu_link,
    $todays_date,
    $message_id,
    $contact_id,
  ];

  $data = str_replace($system_variables_shortcodes, $system_variables_shortcodes_values, $data);
  return $data;
}

  /**
   * Retrun strintg after replace the custom fields shortcodes
  */
  public static function replaceCustomFields($data, $contact_custom_fields)
  {
    $custom_fields = \DB::table('custom_fields')->pluck('tag', 'id');
    foreach ($custom_fields as $id => $tag) {
      $shortcode = '[#'.$tag.'#]'; // custom_field shortcode [#tag#]
      $word = ''; // replace with empty if no custom field for contact
      foreach($contact_custom_fields as $custom_field) {
        if($tag == $custom_field->tag) {
          $word = $custom_field->pivot->data;
        }
      }
      $data = str_replace($shortcode, $word, $data);
    }
    return $data;
  }

  /**
   * Retrun strintg after replace the spintags shortcodes
  */
  public static function replaceSpintags($data)
  {
    $spintags = \DB::table('spintags')->pluck('values', 'tag');
    foreach ($spintags as $tag => $values) {
      $shortcode = '[%'.$tag.'%]'; // spintag shortcode [%tag%]
      $words = Helper::splitLineBreak($values);
      $word = $words[array_rand($words, 1)]; // pick one random word
      $data = str_replace($shortcode, $word, $data);
    }
    return $data;
  }

  /**
   *  Return string after extrat from start and ending values
  */
  public static function extractString($string, $start, $end)
  {
    $start_pos  = strrpos($string , $start)  + strlen($start);
    $end_pos = strpos($string , $end, $start_pos);
    $length = $end_pos - $start_pos + 1;
    return trim(substr($string, $start_pos, $length));
  }

  /**
   * Retrun string with base64 encoding
  */
  public static function base64url_encode($string)
  {
    return quoted_printable_encode(str_replace(array('/'), array('##'), base64_encode($string)));
  }

  /**
   * Retrun string with base64 decoding
  */
  public static function base64url_decode($string)
  {
    return base64_decode(str_replace(array('##'), array('/'), quoted_printable_decode($string)));
  }

  /**
   * Retrun string after extract contenct from body tag
  */
  public static function extractHtmlTagContents($tag, $html)
  {
    if (preg_match("~<body[^>]*>(.*?)</body>~si", $html, $tag_data)) {
      return $tag_data[1];
    }
  }

  /**
   * Get client IP
  */
  public static function getClientIP()
  {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
      if (array_key_exists($key, $_SERVER) === true){
        foreach (explode(',', $_SERVER[$key]) as $ip){
            $ip = trim($ip); // just to be safe
            if (filter_var($ip, FILTER_VALIDATE_IP) !== false){
              return $ip;
            }
          }
        }
      }
    }

  /**
   * Get geographical detail to an IP
  */
  public static function getGeoInfo($ip)
  {
    try{
      $databaseFile = config('mc.path_maxmind_geo_db');
      $reader = new \MaxMind\Db\Reader($databaseFile);
      $maxmind_ip_info = $reader->get($ip);
      $language = 'en';
      $ip_info['country'] = !empty($maxmind_ip_info['country']['names'][$language]) ? $maxmind_ip_info['country']['names'][$language] : null;
      $ip_info['country_code'] = !empty($maxmind_ip_info['country']['iso_code']) ? $maxmind_ip_info['country']['iso_code'] : null;
      $ip_info['zipcode'] = !empty($maxmind_ip_info['postal']['code']) ? $maxmind_ip_info['postal']['code'] : null;

      $ip_info['city'] = !empty($maxmind_ip_info['city']['names'][$language]) ? $maxmind_ip_info['city']['names'][$language] : null;

      if(empty($ip_info['city'])) {
        $ip_info['city'] =  !empty($maxmind_ip_info['subdivisions'][0]['names'][$language]) ? $maxmind_ip_info['subdivisions'][0]['names'][$language] : null;
      }

      $reader->close();
      return $ip_info;
    } catch(\Exception $e) {}

  }

  /**
   * Get cron command
  */
  public static function getCronCommand()
  {
    // Get PHP Path
    try {
      $php_path = exec("which php");
      if(empty($php_path)) {
        $php_path =  "/usr/bin/php";
      }
    } catch (\Exception $e) {
      $php_path =  "/usr/bin/php";
    }
    return "* * * * * ".$php_path .' '.base_path().DIRECTORY_SEPARATOR."artisan schedule:run >/dev/null 2>&1";
  }

  /**
   * Get cron last executed minutes
  */
  public static function getCronLatExecutedMinutes()
  {
    // Get cron last executed minutes
    try{
      $settings_attributes = json_decode(\DB::table('settings')->whereId(config('mc.app_id'))->value('attributes'), true);
      $cron_timestamp = $settings_attributes['cron_timestamp'];
      $cron_last_executed  = \Carbon\Carbon::parse($cron_timestamp)->diffInMinutes(\Carbon\Carbon::now());
    } catch (\Exception $e) {
      echo $e->getMessage();
      $cron_last_executed = 0;
    }
    return $cron_last_executed;
  }


  /**
   * App verification
   * WARNING!!! Avoid to make any changes in it.
  */
  public static function verifyLicense($data)
  {
    $url = config('mc.mailcarry_verify').http_build_query($data);
    return \Helper::getUrl($url);
  }


  /**
   * CURL GET either with http_code if ture then return the http code like 200, 301 etc
  */
  public static function getUrl($url, $http_code=false)
  {
    $ch = curl_init();
    curl_setopt_array(
      $ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
      )
    );
    $result = curl_exec($ch);

    if($http_code) {
      $result  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    curl_close($ch);
    return $result;
  }

  /**
   * Send more than one get requests at once
  */
  public static function parallelRequests($urls = [])
  {
    // Create the multiple cURL handle
    $mh = curl_multi_init();
    foreach($urls as $ch => $url) {
      // Create cURL resources\
      $$ch = curl_init();
      curl_setopt($$ch, CURLOPT_URL, $url);
      curl_setopt($$ch, CURLOPT_HEADER, 0);
      curl_setopt($$ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($$ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($$ch, CURLOPT_SSL_VERIFYPEER, false);

      // Add into handles
      curl_multi_add_handle($mh, $$ch);
    }

    //execute the multi handle
    do {
      $status = curl_multi_exec($mh, $active);
      if ($active) {
        curl_multi_select($mh);
      }
    } while ($active && $status == CURLM_OK);

    //close the handles
    foreach($urls as $ch => $url) {
      curl_multi_remove_handle($mh, $$ch);
    }
    curl_multi_close($mh);
  }

  /**
   * Send more than one get requests at once
  */
  public static function apiReturn($status, $data)
  {
    return response()->json(['status' => $status, 'response' => $data]);
  }

  /**
   * Convrt links and images links for tracking clicks
  */
  public static function convertLinksForClickTracking($id, $tracking_domain, $content, $app_url, $link_param)
  {
    //link_param can be;  d = drip; af = auto followup
    $track_click = $tracking_domain.$link_param.base64_encode($id);
    try {
      $dom = new \DOMDocument('1.0', 'UTF-8');
      libxml_use_internal_errors(true);
      $dom->loadHTML('<?xml encoding="UTF-8">' . $content);
      libxml_use_internal_errors(false);

      foreach($dom->getElementsByTagName('a') as $a) {
        $href = $a->getAttribute('href');
        $href = $track_click."/". Helper::base64url_encode($href);
        $a->setAttribute('href', $href);
      }

      $app_url_without_protocol = parse_url($app_url, PHP_URL_HOST);
      // Update images sources as well
      foreach($dom->getElementsByTagName('img') as $img) {
        $src = $img->getAttribute('src');
        $url_img_src = parse_url($src, PHP_URL_HOST);
        if($url_img_src == $app_url_without_protocol) {
          $src = str_replace($url_img_src, parse_url($tracking_domain, PHP_URL_HOST), $src);
          $img->setAttribute('src', $src );
        }
      }

      $content = $dom->saveHTML(); 
    } catch (\Exception $e) {
      \Log::error('convertLinksForClickTracking => '.$e->getMessage());
    }
    return $content;
  }

  /**
   * Check if email in the suppression
   * return bollean true/false
  */
  public static function isSuppressed($email, $app_id, $list_id=null)
  {
    $is_suppressed = \DB::table('suppressions')
    ->where('app_id', $app_id)
    ->whereEmail($email)
    ->where(function($query) use ($list_id) {
      $query->whereListId($list_id)
      ->orWhere('list_id', null);
    })
    ->exists();
    if($is_suppressed) return true;

    // Suppress Domain data
    $suppression_domains = \DB::table('suppressions')
    ->where('app_id', $app_id)
    ->where('email', 'LIKE', '@%')
    ->where(function($query) use ($list_id) {
      $query->whereListId($list_id)
      ->orWhere('list_id', null);
    })
    ->get();
    foreach ($suppression_domains as $data) {
      if (stripos($email, $data->email) !== false) {
        return true;
      }
    }

    return false;
  }

  /**
   * Return max file size for uploaded file
  */
  public static function getMaxFileSize($only_value=false, $db=false)
  {
    try {
      $upload_max_filesize = ini_get('upload_max_filesize');
      if($only_value) {
        if($db) {
          return Helper::getMaxFileSizeDB();
        } else {
          return str_replace('M','', $upload_max_filesize);
        }
      }
      if($db) {
        return '<i>'.__('app.max_file_size') . ': <b>' . Helper::getMaxFileSizeDB().'M</b></i>';
      } else {
        return '<i>'.__('app.max_file_size') . ': <b>' . $upload_max_filesize.'</b></i>';
      }
      
    } catch(\Exception $e) {
      // nothing
    }
  }

  /**
   * Return max file size for uploaded file from DB
  */
  public static function getMaxFileSizeDB()
  {
    $settings = \DB::table('settings')->whereId(config('mc.app_id'))->first();
    $general_settings = json_decode($settings->general_settings);
    $max_file_size = !empty($general_settings->max_file_size) ? $general_settings->max_file_size : Helper::getMaxFileSize($only_value=true);
    return $max_file_size; // convert into MB
  }

  /**
   * Return max file size for uploaded file into MB
  */
  public static function getMaxFileSizeMB()
  {
    return Helper::getMaxFileSize($only_value=true, $db=true)*1024;
  }

  /**
   * Verify Email and return response
  */
  public static function verifyEmail($data, $encrypt=false)
  {
    $api_key = $encrypt ? \Crypt::decrypt($data['api_key']) : $data['api_key'];
    switch($data['type']) {
      case 'kickbox':
      try {
        $client = new \Kickbox\Client($api_key);
        $kickbox = $client->kickbox();
        $response = $kickbox->verify($data['email']);
        $response = [
          'success' => $response->body['success'],
          'message' => $response->body['result'] . ', ' . $response->body['reason'],
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      break;
      case 'emailoversight':
      try {
        $emailoversight = new \Bcismariu\EmailOversight\EmailOversight($api_key);
        $response = $emailoversight->emailValidation($data['email'], $data['list_id']);
        $status = $response['ResultId'] == 1 ? true : false;
        $response = [
          'success' => $status,
          'message' => $response['Result'],
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      break;
      case 'neverbounce':
      try {
        \NeverBounce\Auth::setApiKey($api_key);
        $response = \NeverBounce\Single::check($data['email'], true, true);
        $status = $response->result == 'invalid' ? false : true;
        $response = [
          'success' => $status,
          'message' => $response->flags[0],
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      break;
      case 'sendgrid':
      try {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.sendgrid.com/v3/validations/']);
        $headers = [
          'Authorization' => 'Bearer ' . $api_key,
          'Accept'        => 'application/json',
        ];

        $response = $client->request('POST', 'email', [
          'headers' => $headers,
          'json' => [
            'email' => $data['email'],
            'source' => 'signup'
           ]
        ])->getBody()->getContents();

        $response = json_decode($response, true);

        $response = [
          'success' => $response['result']['checks']['domain']['has_mx_or_a_record'],
          'message' => $response['result']['verdict'],
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      case 'mailgun':
      try {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.mailgun.net/v4/address/validate', [
          'auth' => ['api', $api_key],
          'form_params' => ['address' => "{$data['email']}"]
        ]);
        $response = json_decode($response, true);
        $status = $response['result'] == 'deliverable' ? 1: 0;
        $response = [
          'success' => $status,
          'message' => "{$response['result']} ({$response['reason']})",
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      break;
      case 'bulkemailchecker':
      try {
        $response = \Helper::getUrl("https://api-v4.bulkemailchecker.com/?key={$api_key}&email=".$data['email']);
        $response = json_decode($response, true);
        $status = !empty($response['status']) && $response['status'] == 'passed' ? 1: 0;
        $response['result'] = !empty($response['error']) ? $response['error'] : $response['email'] ?? '';
        $response = [
          'success' => $status,
          'message' => "{$response['result']}",
          'increment' => true
        ];
      } catch (\Exception $e) {
        $response = [
          'success' => false,
          'message' => $e->getMessage(),
          'increment' => false
        ];
      }
      break;
    }

    return $response;
  } // end Switch

  /**
  * List of domins that needs to check for blacklisted
  */
  public static function DNSBLLookup($ip, $domain = false)
  {
    $dnsbl_lookup = [
      "0spam.fusionzero.com",
      "3y.spam.mrs.kithrup.com",
      "access.redhawk.org",
      "all.rbl.jp",
      "all.spamrats.com",
      "all.rbl.kropka.net",
      "aspews.ext.sorbs.net",
      "all.spamblock.unit.liu.se",
      "assholes.madscience.nl",
      "b.barracudacentral.org",
      "bb.barracudacentral.org",
      "bl.borderworlds.dk",
      "bl.csma.biz",
      "bl.redhatgate.com",
      "bl.spamcannibal.org",
      "bl.spamcop.net",
      "bl.starloop.com",
      "bl.technovision.dk",
      "blackholes.five-ten-sg.com",
      "blackholes.intersil.net",
      "blackholes.mail-abuse.org",
      "blackholes.sandes.dk",
      "blackholes.uceb.org",
      "blackholes.wirehub.net",
      "blacklist.woody.ch",
      "blacklist.sci.kun.nl",
      "blacklist.spambag.org",
      "block.dnsbl.sorbs.net",
      "blocked.hilli.dk",
      "blocklist.squawk.com",
      "blocklist2.squawk.com",
      "cart00ney.surriel.com",
      "cbl.abuseat.org",
      "cbl.anti-spam.org.cn",
      "cblplus.anti-spam.org.cn",
      "cdl.anti-spam.org.cn",
      "combined.abuse.ch",
      "db.wpbl.info",
      "dev.null.dk",
      "dews.qmail.org",
      "dialup.blacklist.jippg.org",
      "dialup.rbl.kropka.net",
      "dialups.mail-abuse.org",
      "dialups.visi.com",
      "dnsbl.ahbl.org",
      "dnsbl.antispam.or.id",
      "dnsbl.cyberlogic.net",
      "nsbl.kempt.net",
      "dnsbl.njabl.org",
      "dnsbl.solid.net",
      "dnsbl.sorbs.net",
      "dnsrbl.swinog.ch",
      "drone.abuse.ch",
      "dnsbl-0.uceprotect.net",
      "dnsbl-1.uceprotect.net",
      "dnsbl-2.uceprotect.net",
      "dnsbl-3.uceprotect.net",
      "dnsbl.inps.de",
      "dnsbl.kempt.net",
      "dsbl.dnsbl.net.au",
      "duinv.aupads.org",
      "dul.dnsbl.sorbs.net",
      "dul.ru",
      "dun.dnsrbl.net",
      "dyna.spamrats.com",
      "dynablock.njabl.org",
      "dynablock.wirehub.net",
      "escalations.dnsbl.sorbs.net",
      "fl.chickenboner.biz",
      "forbidden.icm.edu.pl",
      "form.rbl.kropka.net",
      "hil.habeas.com",
      "http.dnsbl.sorbs.net",
      "http.opm.blitzed.org",
      "httpbl.abuse.ch",
      "intruders.docs.uu.se",
      "ip.rbl.kropka.net",
      "korea.services.net",
      "l1.bbfh.ext.sorbs.net",
      "l2.bbfh.ext.sorbs.net",
      "l3.bbfh.ext.sorbs.net",
      "l4.bbfh.ext.sorbs.net",
      "l1.spews.dnsbl.sorbs.net",
      "l2.spews.dnsbl.sorbs.net",
      "list.bbfh.org",
      "lame-av.rbl.kropka.net",
      "list.dsbl.org",
      "mail-abuse.blacklist.jippg.org",
      "map.spam-rbl.com",
      "misc.dnsbl.sorbs.net",
      "msgid.bl.gweep.ca",
      "multihop.dsbl.org",
      "new.spam.dnsbl.sorbs.net",
      "noptr.spamrats.com",
      "no-more-funn.moensted.dk",
      "ohps.bl.reynolds.net.au",
      "ohps.dnsbl.net.au",
      "old.spam.dnsbl.sorbs.net",
      "omrs.bl.reynolds.net.au",
      "omrs.dnsbl.net.au",
      "op.rbl.kropka.net",
      "opm.blitzed.org",
      "or.rbl.kropka.net",
      "orbs.dorkslayers.com",
      "orid.dnsbl.net.au",
      "orvedb.aupads.org",
      "osps.bl.reynolds.net.au",
      "osps.dnsbl.net.au",
      "osrs.bl.reynolds.net.au",
      "osrs.dnsbl.net.au",
      "owfs.bl.reynolds.net.au",
      "owfs.dnsbl.net.au",
      "owps.bl.reynolds.net.au",
      "owps.dnsbl.net.au",
      "pbl.spamhaus.org",
      "pdl.dnsbl.net.au",
      "problems.dnsbl.sorbs.net",
      "probes.dnsbl.net.au",
      "proxy.bl.gweep.ca",
      "proxies.dnsbl.sorbs.net",
      "psbl.surriel.com",
      "pss.spambusters.org.ar",
      "rbl.cluecentral.net",
      "rbl.efnet.org",
      "rbl.efnetrbl.org",
      "rbl.interserver.net",
      "rbl.orbitrbl.com",
      "recent.spam.dnsbl.sorbs.net",
      "relays.dnsbl.sorbs.net",
      "rbl.rangers.eu.org",
      "sorbs.net",
      "rbl.schulte.org",
      "rbl.snark.net",
      "rbl.triumf.ca",
      "rblmap.tu-berlin.de",
      "rdts.bl.reynolds.net.au",
      "rdts.dnsbl.net.au",
      "relays.bl.gweep.ca",
      "relays.bl.kundenserver.de",
      "relays.dorkslayers.com",
      "relays.mail-abuse.org",
      "relays.nether.net",
      "relays.visi.com",
      "ricn.bl.reynolds.net.au",
      "ricn.dnsbl.net.au",
      "rmst.bl.reynolds.net.au",
      "rmst.dnsbl.net.au",
      "rsbl.aupads.org",
      "safe.dnsbl.sorbs.net",
      "satos.rbl.cluecentral.net",
      "sbl.csma.biz",
      "sbl.spamhaus.org",
      "short.rbl.jp",
      "sbl-xbl.spamhaus.org",
      "smtp.dnsbl.sorbs.net",
      "socks.dnsbl.sorbs.net",
      "socks.opm.blitzed.org",
      "sorbs.dnsbl.net.au",
      "spam.abuse.ch",
      "spam.dnsbl.sorbs.net",
      "spam.spamrats.com",
      "spam.dnsrbl.net",
      "spamrbl.imp.ch",
      "spamsources.fabel.dk",
      "spam.olsentech.net",
      "spam.wytnij.to",
      "spamguard.leadmon.net",
      "spamsites.dnsbl.net.au",
      "spamsources.dnsbl.info",
      "spamsources.fabel.dk",
      "spamsources.yamta.org",
      "spews.dnsbl.net.au",
      "t1.bl.reynolds.net.au",
      "t1.dnsbl.net.au",
      "tor.dan.me.uk",
      "tor.efnet.org",
      "torexit.dan.me.uk",
      "ucepn.dnsbl.net.au",
      "unconfirmed.dsbl.org",
      "vbl.messagelabs.com",
      "virus.rbl.jp",
      "vox.schpider.com",
      "web.dnsbl.sorbs.net",
      "whois.rfc-ignorant.org",
      "will-spam-for-food.eu.org",
      "wingate.opm.blitzed.org",
      "wormrbl.imp.ch",
      "xbl.spamhaus.org",
      "zen.spamhaus.org",
      "zombie.dnsbl.sorbs.net",
      "ztl.dorkslayers.com"
    ];

    $listed = [];
    $counts = 0;
    $ip = $domain ? gethostbyname($ip) : $ip;
    $reverse_ip = implode(".", array_reverse(explode(".", $ip)));
    foreach($dnsbl_lookup as $host) {
      if(checkdnsrr($reverse_ip.".".$host."."."A")){
        $listed[$host] = 'Yes';
        $counts++;
      } else {
        $listed[$host] = 'No';
      }
    }
    $listed['counts'] = $counts;
    return $listed;
  }

  /**
   * Check IPs / Domains Lookup
  */
  public static function checkIPsDomainsLookup()
  {
    // First need to empty the table otherwise duplicate entries
    \DB::table('blacklisteds')->truncate();

    // Check Smtps
    $sending_servers = \App\Models\SendingServer::whereStatus('Active')
    ->whereType('smtp')
    ->get();

    foreach($sending_servers as $sending_server) {
      $host = json_decode($sending_server->sending_attributes, true)['host'];
      if(filter_var($host, FILTER_VALIDATE_IP)) {
        $result = \Helper::DNSBLLookup($host);
        $ip_domain = 'ip';
      } else {
        $result = \Helper::DNSBLLookup($host, $domain=true);
        $ip_domain = 'domain';
      }

      // Get counts
      $counts = array_pop($result);

      // Save data
      \DB::table('blacklisteds')->insert([
        'name' => $host,
        'ip_domain' => $ip_domain,
        'counts' => $counts,
        'detail' => json_encode($result),
        'app_id' => $sending_server->app_id,
        'user_id' => $sending_server->user_id,
        'created_at' => \Carbon\Carbon::now()
      ]);
    }

    // Check Sending Domains
    $sending_domains = \App\Models\SendingDomain::whereActive('Yes')->get();

    foreach($sending_domains as $domain) {
      $host = $domain->domain;
      if(filter_var($host, FILTER_VALIDATE_IP)) {
        $result = \Helper::DNSBLLookup($host);
        $ip_domain = 'ip';
      } else {
        $result = \Helper::DNSBLLookup($host, $domain=true);
        $ip_domain = 'domain';
      }

      // Get counts
      $counts = array_pop($result);

      // Save data
      \DB::table('blacklisteds')->insert([
        'name' => $host,
        'ip_domain' => $ip_domain,
        'counts' => $counts,
        'detail' => json_encode($result),
        'app_id' => $sending_server->app_id,
        'user_id' => $sending_server->user_id,
        'created_at' => \Carbon\Carbon::now()
      ]);
    }
  }

  /**
   * Default Pages/Email data
  */

  public static function defaultPagesEamils($app_id)
  {
    $pages = [
      [
        'name' => 'Welcome Email',
        'slug' => 'welcome-email',
        'type' => 'Email',
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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
        'app_id' => $app_id,
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

    \DB::table('pages')->insert($pages);
  }

  /*
   * Get the allowed limit to client
  */
  public static function getClientAttributeValue($app_id, $section)
  {
    // Need to fetch first recored, it would be client always
    $package_id = \App\Models\User::whereAppId($app_id)->orderBy('id')->value('package_id');
    if(!empty($package_id)) {
      $attributes = json_decode(\App\Models\Package::whereId($package_id)->orderBy('id')->value('attributes'), true);
    } else {
      $attributes[$section] = null;
    }
    
    return $attributes[$section];
  }

  /*
   * Return true/false according to the limit to a client
  */
  public static function allowedLimit($app_id, $section, $table)
  {
    // If Superadmin/Superadmin users
    if($app_id == config('mc.app_id')) return true;

    $allowed_limit = \Helper::getClientAttributeValue($app_id, $section);
    // Client limit is unlimited
    if($allowed_limit == -1) return true;

    $exist = \DB::table($table)->whereAppId($app_id)->count();
    return $allowed_limit > $exist ? true : false;
  }

  /*
   * Return value either unlimited to display
  */
  public static function displayValueOrUnlimited($app_id, $section)
  {
    $allowed_limit = \Helper::getClientAttributeValue($app_id, $section);
    return $allowed_limit == -1 ? "&infin;" : $allowed_limit;
  }

  /*
   * Get table, stat_id, email for campaign, drip, and auto-followup against message_id
  */
  public static function statMessageDetail($message_id)
  {
    $message_id = trim(trim($message_id), '<>');
    $table_app_id = 'schedule_campaign_stats';
    $table = 'schedule_campaign_stat_logs';
    $section = 'Campaign';
    $stat = \DB::table($table)
    ->whereMessageId($message_id)
    ->select('id', 'email', 'sending_server', 'schedule_campaign_stat_id as schedule_id')
    ->first();
    
    if(empty($stat->id)) {
      $table_app_id = 'auto_followup_stats';
      $table = 'auto_followup_stat_logs';
      $section = 'AutoFollowup';
      $stat = \DB::table($table)
      ->whereMessageId($message_id)
      ->select('id', 'email', 'sending_server', 'auto_followup_stat_id as schedule_id')
      ->first();
      if(empty($stat->id)) {
        $table_app_id = 'schedule_drip_stats';
        $table = 'schedule_drip_stat_logs';
        $section = 'Drip';
        $stat = \DB::table($table)
        ->whereMessageId($message_id)
        ->select('id', 'email', 'sending_server', 'schedule_drip_stat_id as schedule_id')
        ->first();
      }
    }

    // Get App ID
    if(!empty($stat->id)) {
      $app_id = \DB::table($table_app_id)->whereId($stat->schedule_id)->value('app_id');
    }

    return [
      $table ?? null,
      $stat->id ?? null,
      $stat->email ?? null,
      $stat->sending_server ?? null,
      $section ?? null,
      $app_id ?? null,
    ];
  }

  /*
   * Save bounce data for campaing, drips, auto-follwups
  */
  public static function saveBounce($to_email, $stat_id, $section, $code, $type, $short_detail, $full_detail, $app_id)
  {
    // Insert bounce data if not already exist
    if(!empty($to_email) && !\App\Models\ScheduleCampaignStatLogBounce::whereScheduleCampaignStatLogId($stat_id)->whereSection($section)->exists()) {
      try {
        $bounce_data = [
          'schedule_campaign_stat_log_id' => $stat_id,
          'section' => $section,
          'email'  => $to_email,
          'code'   => $code,
          'type'   => $type,
          'detail' => json_encode(['short_detail' => $short_detail, 'full_detail' => $full_detail]),
          'app_id' => $app_id,
          'created_at' => \Carbon\Carbon::now(),
        ];
        \App\Models\ScheduleCampaignStatLogBounce::create($bounce_data);
      } catch(\Exception $e) {
        $error = $e->getMessage();
        \Log::error("save-bounces-{$section} => ".$error);
        // nothing to do
      }
    }
  }

  /*
   * Save spam data for campaing, drips, auto-follwups
  */
  public static function saveSpam($to_email, $stat_id, $section, $full_detail, $app_id)
  {
    // Insert bounce data if not already exist
    if(!empty($to_email) && !\App\Models\ScheduleCampaignStatLogSpam::whereScheduleCampaignStatLogId($stat_id)->whereSection($section)->exists()) {
      try {
        $spam_data = [
          'schedule_campaign_stat_log_id' => $stat_id,
          'section' => $section,
          'email'  => $to_email,
          'detail' => json_encode(['full_detail' => $full_detail]),
          'app_id' => $app_id,
          'created_at' => \Carbon\Carbon::now(),
        ];
        \App\Models\ScheduleCampaignStatLogSpam::create($spam_data);
      } catch(\Exception $e) {
       echo $error = $e->getMessage();
       \Log::error("save-spam-{$section} => ".$error);
        // nothing to do
      }
    }
  }

  /*
   * Save get broadcasts links
  */
  public static function getBroadcastLinks($broadcast_ids)
  {
    $broadcasts = \App\Models\Broadcast::whereIn('id', $broadcast_ids)->distinct()->get();
    $links = [];
    foreach($broadcasts as $broadcast) {
      try {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $broadcast->content_html);
        libxml_use_internal_errors(false);

        foreach($dom->getElementsByTagName('a') as $a) {
          $href = $a->getAttribute('href');
          if(stripos($href, '[$unsub-link$]') === false)
            array_push($links, $href);
        } 
      } catch (\Exception $e) {
        \Log::error('getBroadcastLinks => '.$e->getMessage());
      }
    }
    return $links;
  }

  // Replace XSS tags
  public static function XSSReplaceTags($input)
  {
    return str_ireplace(['<script', '</script>', 'onmouseover', 'onmouseout', 'onmouseup', 'onload', 'onclick', 'equiv', 'alert', 'javascript','javascript','iframe', '"="', '""=""', '" ""', '""'], ['', '', '', '', '', '', '', '', '', '', '', '', '"', '"', '"', '"'], $input);
  }

  // Encode save string
  public static function encodeString($input)
  {
    return htmlentities($input, ENT_QUOTES);
  }

  // Decode string
  public static function decodeString($input)
  {
    return html_entity_decode($input, ENT_QUOTES);
  }

  /**
   * Return ture/false after verify domain DKIM
  */
  public static function verifyDKIM($sending_domain)
  {
    // Should be set to unverified before verifcation
    \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_key' => 0]);

    $key = false;
    $dkim_host = $sending_domain->dkim.'._domainkey.'.$sending_domain->domain.'.';
    $dkim_values = dns_get_record($dkim_host, DNS_TXT);

    if (!empty($dkim_values)) {
      foreach($dkim_values as $dns_txt) {
        // public key verification
        $public_key = str_replace(['-----BEGINPUBLICKEY-----', '-----ENDPUBLICKEY-----'], ['', ''], $sending_domain->public_key);
        if(strpos($dns_txt['txt'], $public_key) !== false) {
          \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_key' => 1]);
          $key = true;
        }
      }
    }
    return $key;
  }

  /**
   * Return ture/false after verify domain SPF
  */
  public static function verifySPF($sending_domain)
  {
    // Should be set to unverified before verifcation
    \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_spf' => 0]);

    $spf = false;
    $spf_host = $sending_domain->domain.'.';
    $spf_values = Helper::getSPFRecordForDomain($spf_host);

    if (!empty($spf_values)) {
      foreach($spf_values as $dns_txt) {
        // spf verification
        if($sending_domain->pmta) {
          if(!empty($dns_txt['txt']) && $dns_txt['txt'] == $sending_domain->spf_value) {
            \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_spf' => 1]);
            $spf = true;
          }
        } else {
          //if($dns_txt['txt'] == "v=spf1 mx a ip4:{$_SERVER['SERVER_ADDR']} ~all") {
          // not strice check only server ip check
          //if(strpos($dns_txt['txt'], $_SERVER['SERVER_ADDR']) !== false) {
          if(!empty($dns_txt)) {
            \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_spf' => 1]);
            $spf = true;
            break;
          }
        }
      }
    }
    return $spf;
  }

  /**
   * Return ture/false after verify domain DMARC
  */
  public static function verifyDMARC($sending_domain)
  {
    // Should be set to unverified before verifcation
    \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_dmarc' => 0]);

    $dmarc = false;
    $dmarc_host = '_dmarc.'.$sending_domain->domain.'.';
    $dmarc_values = dns_get_record($dmarc_host, DNS_TXT);

    if (!empty($dmarc_values)) {
      foreach($dmarc_values as $dns_txt) {
        // dmarc verification
        if($dns_txt['txt'] == "v=DMARC1;p=none;rua=mailto:{$sending_domain->dmarc}@{$sending_domain->domain};ruf=mailto:{$sending_domain->dmarc}@{$sending_domain->domain}" || 
        strpos($dns_txt['txt'], "v=DMARC1;p=none;") !== false) {
          \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_dmarc' => 1]);
          $dmarc = true;
        }
      }
    }
    return $dmarc;
  }

  /**
   * Return ture/false after verify domain Tracking
  */
  public static function verifyTracking($sending_domain)
  {
    // Should be set to unverified before verifcation
    \App\Models\SendingDomain::whereId($sending_domain->id)->update([ 'verified_tracking' => 0]);

    $tracking = false;
    // cname verification
    $cname_host = $sending_domain->protocol.$sending_domain->tracking.'.'.$sending_domain->domain;

    $response = json_decode(Helper::getUrl($cname_host.'/ok'), true);
    if(!empty($response['success']) && $response['success'] == 'success') {
      \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_tracking' => 1]);
      $tracking = true;
    }

    // Second check normally creats the issue with DNS cache
    /*if(!$tracking) {
      $cname_values = dns_get_record($cname_host, DNS_CNAME);
      if (!empty($cname_values)) {
        foreach($cname_values as $cname) {
          if(trim($cname['target']) == trim(\Helper::getAppURL(true))) {
            \App\Models\SendingDomain::whereId($sending_domain->id)->update(['verified_tracking' => 1]);
            $tracking = true;
            break;
          }
        }
      }
    }*/

    return $tracking;
  }

  public static function getSPFRecordForDomain($domain)
    {
        $records = dns_get_record($domain, DNS_TXT | DNS_SOA);
        if (false === $records) {
            throw new DNSLookupException;
        }

        $spfRecords = array();
        foreach ($records as $record) {
            if ($record['type'] == 'TXT') {
                $txt = strtolower($record['txt']);
                // An SPF record can be empty (no mechanism)
                if ($txt == 'v=spf1' || stripos($txt, 'v=spf1 ') === 0) {
                    $spfRecords[] = $txt;
                }
            }
        }

        return $spfRecords;
    }
}