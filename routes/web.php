<?php
Auth::routes();

Route::get("/clear_cache", function () {
  Artisan::call('config:cache');
  Artisan::call('cache:clear');
  Artisan::call('view:clear');
});

Route::get("/mc_schedules_run", function () {
  Artisan::call('schedule:run');
});

Route::group(['middleware' => ['language', 'auth', 'XssSanitizer']], function () {
  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
  Route::get('/campaigns/sent/{type?}', 'DashboardController@getSentData')->name('campaigns.sent.data');

  Route::get('/notification/read/{id}', 'NotificationController@read')->name('notification.read');
  Route::get('/notification/read_all', 'NotificationController@readAll')->name('notification.read.all');
  Route::get('/users', 'UserController@index')->name('users.index');
  Route::get('/get-users', 'UserController@getUsers')->name('users');
  Route::get('/profile', 'UserController@profile')->name('profile');
  // impersonate user
  Route::get('/impersonate/{id}', function($id){
    Auth::loginUsingId($id)->whereParentId(Auth::user()->parent_id);
    if($id == config('mc.app_id')) 
       Session::forget('impersonate');
    else
      session(['impersonate' => true]);
    return redirect()->route('dashboard');
  })->name('user.impersonate');
  Route::resource('user', 'UserController', ['except' => ['index']]);

  // Clients
  Route::get('/clients', 'ClientController@index')->name('clients.index');
  Route::get('/get-clients', 'ClientController@getClients')->name('clients');
  Route::resource('client', 'ClientController', ['except' => ['index']]);

  // Packages
  Route::get('/packages', 'PackageController@index')->name('packages.index');
  Route::get('/get_packages', 'PackageController@getPackages')->name('packages');
  Route::resource('package', 'PackageController', ['except' => ['index']]);
  Route::get('/get_packages_list/{return_type?}', function($return_type){
    return $return_type == 'json' ? \App\Models\Package::whereAppId(Auth::user()->app_id)->pluck('name', 'id')->toJson() : \App\Models\Package::whereAppId(Auth::user()->app_id)->select('id', 'name')->get();
  })->name('get.packages.list');

  Route::get('/roles', 'RolesPermissionsController@index')->name('roles_permissions.index');
  Route::get('/getRoles', 'RolesPermissionsController@getRoles')->name('getRoles');
  Route::get('/role/create', 'RolesPermissionsController@createRole')->name('role.create');
  Route::post('/roles_permissions', 'RolesPermissionsController@saveRole')->name('roles_permissions.save.role');
  Route::put('/roles_permissions', 'RolesPermissionsController@updateRole')->name('roles_permissions.update.role');
  Route::delete('/roles_permissions/{id}', 'RolesPermissionsController@destroyRole')->name('roles_permissions.destroy.role');
  Route::get('/permissions/{role_id}', 'RolesPermissionsController@rolePermissions')->name('roles_permissions.permissions');
  Route::post('/permissions', 'RolesPermissionsController@savePermissions')->name('roles_permissions.save.permissions');
  Route::get('/get_roles/{return_type?}', function($return_type){
    return $return_type == 'json' ? \Spatie\Permission\Models\Role::whereAppId(Auth::user()->app_id)->pluck('name', 'id')->toJson() : \Spatie\Permission\Models\Role::whereAppId(Auth::user()->app_id)->select('id', 'name')->get();
  })->name('get_roles');

  // groups
  Route::get('/group/create/{type_id}', 'GroupController@create')->name('group.create');
  Route::put('/group', 'GroupController@update')->name('group.update');
  Route::get('/groups/{type_id}/{return_type?}', 'GroupController@groups')->name('groups');
  Route::post('/group', 'GroupController@store')->name('group.save');
  Route::delete('/group-delete/{model}', 'GroupController@deleteGroup')->name('group.delete');

  // lists
  Route::get('/lists', 'ListController@index')->name('lists.index');
  Route::get('/get-lists', 'ListController@getLists')->name('lists');
  Route::post('/list-empty/{id}', 'ListController@emtpy')->name('list.empty');
  Route::any('/list-split/{id?}', 'ListController@split')->name('list.split');
  Route::any('/list-clean/{id}', 'ListController@clean')->name('list.clean');
  Route::get('/list/copy/{id}', 'ListController@copy')->name('list.copy');
  Route::get('/list/bulk_update', 'ListController@bulkUpdate')->name('bulk_update');
  Route::post('/list/bulk_update', 'ListController@bulkUpdate')->name('bulk_update.post');
  Route::resource('list', 'ListController', ['except' => ['index']]);

  // get campaigns
  Route::get('/broadcasts_dropdown', function(){
    return \App\Models\Broadcast::pluck('name', 'id');
  })->name('broadcasts.dropdown');

  // get countries
  Route::get('/countries', function(){
    return Helper::countries();
  })->name('countries');

  // get shortcodes
  Route::get('/shortcodes/{section?}', function($section='all'){
    return Helper::shortcodes($section);
  })->name('shortcodes');

  // send email
  //Route::post('/send-email', 'ListController@emtpy')->name('send.email');
  Route::get('/send_email/{broadcast_id}/{sending_server_id}/{template_id}', function($broadcast_id, $sending_server_id, $template_id){
    return view('includes.email_send')->with(compact('broadcast_id', 'sending_server_id', 'template_id'));
  })->name('send.email');
  Route::post('/send_email_test', 'SendingServerController@sendEmailTest');

    //custom fields
  Route::get('/customFieldsData/{return_type?}', function(){
    return \App\Models\CustomField::customFields('json');
  })->name('customFieldsData');
  Route::get('/custom-fields', 'CustomFieldController@index')->name('custom_fields.index');
  Route::get('/get-custom-fields', 'CustomFieldController@getCustomFields')->name('custom_fields');
  Route::resource('custom_field', 'CustomFieldController', ['except' => ['index', 'show']]);

  //contacts
  Route::get('/contacts', 'ContactController@index')->name('contacts.index');
  Route::get('/get-concacts', 'ContactController@getContacts')->name('contacts');
  Route::any('/contacts-export/{id}/{field?}', 'ContactController@contactsExport')->name('contacts.export');
  Route::any('/contacts-import/{id}', 'ContactController@contactsImport')->name('contacts.import');
  Route::get('/contacts-import-status/{id}', 'ContactController@contactsImportStatus');
  Route::get('/lists-custom-fields', 'ContactController@getListsCustomFields')->name('list.custom_fields');
  Route::resource('contact', 'ContactController', ['except' => ['index']]);

  // broadcasts
  Route::get('/broadcasts', 'BroadcastController@index')->name('broadcasts.index');
  Route::get('/get_broadcasts', 'BroadcastController@getBroadcasts')->name('broadcasts');
  Route::get('/broadcast/copy/{id}', 'BroadcastController@copy')->name('broadcast.copy');
  Route::resource('broadcast', 'BroadcastController', ['except' => ['index']]);


  // schedules campaigns
  Route::get('/scheduled_campaigns', 'ScheduleCampaignController@index')->name('scheduled.campaigns.index');
  Route::get('/get_scheduled_campaigns', 'ScheduleCampaignController@getScheduledCampaigns')->name('scheduled.campaigns');
  Route::get('/get_scheduled_campaign_detail/{id}', 'ScheduleCampaignController@getScheduledDetail')->name('scheduled.detail.campaign');
  Route::get('/reschedule/{id}', 'ScheduleCampaignController@reschedule')->name('reschedule');
  Route::put('/limited_to_unlimited', 'ScheduleCampaignController@limitedToUnlimited')->name('limited.to.unlimited');
  Route::put('/update_schedule_campaign_status/{id}', 'ScheduleCampaignController@updateScheduleStatus');
  Route::resource('schedule_campaign', 'ScheduleCampaignController', ['except' => ['index']]);


    // Drips
  Route::get('/drips', 'DripController@index')->name('drips.index');
  Route::get('/get_drips', 'DripController@getDrips')->name('drips');
  Route::resource('drip', 'DripController', ['except' => ['index', 'show']]);

  // Schedules drips
  Route::get('/scheduled_drips', 'ScheduleDripController@index')->name('scheduled.drips.index');
  Route::get('/get_scheduled_drips', 'ScheduleDripController@getScheduledDrips')->name('scheduled.drips');
  Route::put('/update_schedule_drip_status/{id}', 'ScheduleDripController@updateScheduleStatus');
  Route::resource('schedule_drip', 'ScheduleDripController', ['except' => ['index', 'show']]);

  // Auto Followups
  Route::get('/auto_followups', 'AutoFollowupController@index')->name('auto_followups.index');
  Route::get('/get_auto_followups', 'AutoFollowupController@getAutoFollowups')->name('auto_followups');
  Route::resource('auto_followup', 'AutoFollowupController', ['except' => ['index', 'show']]);

  // Triggres
  Route::get('/triggers', 'TriggerController@index')->name('triggers.index');
  Route::get('/get_triggers', 'TriggerController@getTriggers')->name('triggers');
  Route::put('/restartTrigger/{id}', 'TriggerController@restartTrigger')->name('restartTrigger');
  Route::resource('trigger', 'TriggerController', ['except' => ['index', 'show']]);
  Route::get('/get_based_on_data/{type}/{action}/{id?}', 'TriggerController@getBasedOnData');

  // Segments
  Route::get('/segments', 'SegmentController@index')->name('segments.index');
  Route::get('/get_segments', 'SegmentController@getSegments')->name('segments');
  Route::get('/segment/create/{by}', 'SegmentController@create')->name('segment.create');
  Route::get('/segment/action/{id}/{action}', 'SegmentController@action')->name('segment.action');
  Route::put('/segment/action/{id}', 'SegmentController@action')->name('segment.update.action');
  Route::resource('segment', 'SegmentController', ['except' => ['index', 'create']]);
  Route::get('/get_segment_attributes/{action}/{segment_action}/{scheduled_ids?}/{id?}', 'SegmentController@getAttributes');

  // Spin tags
  Route::get('/spintags', 'SpintagController@index')->name('spintags.index');
  Route::get('/get_spintags', 'SpintagController@getSpintags')->name('spintags');
  Route::resource('spintag', 'SpintagController', ['except' => ['index']]);

  // Sending Domains
  Route::get('/sending_domains', 'SendingDomainController@index')->name('sending_domains.index');
  Route::get('/get_sending_domains', 'SendingDomainController@getSendingDomains')->name('sending_domains');
  Route::get('/download_keys/{id}', 'SendingDomainController@downloadKeys')->name('download.keys');
  Route::get('/domain_verfications/{id}/{type}', 'SendingDomainController@domainVerifications')->name('domain.verifications');
  Route::resource('sending_domain', 'SendingDomainController', ['except' => ['index', 'edit']]);

  // Sending Servers
  Route::get('/sending_servers', 'SendingServerController@index')->name('sending_servers.index');
  Route::get('/get_sending_servers', 'SendingServerController@getSendingServers')->name('sending_servers');
  Route::get('/get_sending_server_fields/{type}/{action}/{id?}', 'SendingServerController@getSendingServerFields');
  Route::get('/sending_server/copy/{id}', 'SendingServerController@copy')->name('sending_server.copy');
  Route::put('/sending_server/reset_counter/{id}', 'SendingServerController@resetCounter')->name('sent.clear');
  Route::get('/sending_server/status/{id}', function($id){
    return view('sending_servers.status')->with('id', $id);
  })->name('sending_server.status');
  Route::resource('sending_server', 'SendingServerController', ['except' => ['index', 'show']]);
  Route::get('/callback_help/{type}', function($type){
    return view('sending_servers.callback_help')->with('type', $type);
  })->name('callback.help');

  //Bounces
  Route::get('/bounces', 'BounceController@index')->name('bounces.index');
  Route::get('/get_bounces', 'BounceController@getBounces')->name('bounces');
  Route::resource('bounce', 'BounceController', ['except' => ['index']]);
  Route::get('/validate_imap', 'BounceController@validateImap');
  Route::get('/get-bounces/{return_type?}', function($return_type){
    return \App\Models\Bounce::getBounces($return_type);
  })->name('get_bounces');
  //Route::get('/get-bounces/{return_type?}')->name('get_bounces');

  //FBL
  Route::get('/fbls', 'FblController@index')->name('fbls.index');
  Route::get('/get_fbls', 'FblController@getFbls')->name('fbls');
  Route::resource('fbl', 'FblController', ['except' => ['index']]);

  // Email Verifiers
  Route::get('/email_verifiers', 'EmailVerifierController@index')->name('email.verifiers.index');
  Route::get('/get_email_verifiers', 'EmailVerifierController@getEmailVerifiers')->name('email.verifiers');
  Route::resource('email_verifier', 'EmailVerifierController', ['except' => ['index']]);
  Route::get('/get_email_verifiers_fields/{type}/{action}/{id?}', 'EmailVerifierController@getEmailVerifiersFields');
  Route::get('/verify_email', 'EmailVerifierController@verifyEmail')->name('verify.email');
  Route::any('/verify_email_list', 'EmailVerifierController@verifyEmailList')->name('verify.email.list');

  // Suppression
  Route::get('/suppressions', 'SuppressionController@index')->name('suppressions.index');
  Route::get('/get_suppressions', 'SuppressionController@getSuppressions')->name('suppressions');
  Route::get('/suppression/create', 'SuppressionController@create')->name('suppression.create');
  Route::post('/suppression', 'SuppressionController@store')->name('suppression.store');
  Route::delete('/suppression/{id}', 'SuppressionController@destroy')->name('suppression.destroy');

  // Settings
  Route::get('/settings', 'SettingController@index')->name('settings');
  Route::post('/settings', 'SettingController@update')->name('settings.update');
  Route::get('/settings/api', 'SettingController@api')->name('settings.api');
  Route::put('/settings/api', 'SettingController@api')->name('settings.api');
  Route::put('/settings/api-status', 'SettingController@apiStatus')->name('settings.api.status');
  Route::any('/settings/mail-headers', 'SettingController@mailHeaders')->name('settings.mail.headers');
  Route::post('/settings/license_verification', 'SettingController@licenseVerification')->name('settings.license.verification');

  // Templates
  Route::get('/templates/all', function() {
    return view('templates.all');
  })->name('templates.all');
  Route::get('/template/html/{id}', 'TemplateController@getHTMLContent');
  Route::get('/templates', 'TemplateController@index')->name('templates.index');
  Route::get('/get_templates', 'TemplateController@getTemplates')->name('templates');
  Route::get('/get_mc_builder', 'TemplateController@getMCBuilder')->name('get_mc_builder');
  Route::get('/get_mc_builder_2', 'TemplateController@getMCBuilder2')->name('get_mc_builder_2');
  Route::post('/template_save', 'TemplateController@save')->name('template.save');
  Route::resource('template', 'TemplateController', ['except' => ['index', 'store', 'update']]);

  // Webform
  Route::get('/webforms', 'WebformController@index')->name('webforms.index');
  Route::get('/get_webforms', 'WebformController@getWebforms')->name('webforms');
  Route::get('/webform/copy/{id}', 'WebformController@copy')->name('webform.copy');
  Route::resource('webform', 'WebformController', ['except' => ['index', 'show']]);
  Route::get('/webform/{id}/{get_html?}', 'WebformController@show')->name('webform.show');

  // Pages
  Route::get('/pages', 'PageController@index')->name('pages.index');
  Route::get('/get_pages', 'PageController@getPages')->name('pages');
  Route::resource('page', 'PageController', ['except' => ['index']]);
  Route::get('/page_html/{slug}', 'PageController@showPage')->name('page.html');

  Route::get('/images_manager', function(){
    Helper::checkPermissions('image_manager'); // check user permission
    return view('tools.images_manager')->with('page', 'tools_image_manager');
  })->name('images.manager');

  Route::get('/backup', function(){
    Helper::checkPermissions('backup'); // check user permission
    return view('tools.backup');
  })->name('backup');
  Route::post('/backup', 'ToolController@backup')->name('backup');

  Route::get('/logs', 'ToolController@logsIndex')->name('logs.index');
  Route::get('/get_logs', 'ToolController@getLogs')->name('logs');
  Route::get('/update', 'ToolController@appUpdate')->name('app.update');
  Route::post('/update', 'ToolController@appUpdateProceed')->name('app.update.proceed');

  // Stats Campaigns
  Route::get('/stats/campaigns', 'ScheduleCampaignStatController@index')->name('stats.campaigns.index');
  Route::get('/get_stats_campaigns', 'ScheduleCampaignStatController@getStatsCampaigns')->name('stats.campaigns');
  Route::get('/get_scheduled_detail_stat_campaign/{id}', 'ScheduleCampaignController@getScheduledDetail')->name('scheduled.detail.stat.campaign');
  Route::get('/stat/export/{id}', 'ScheduleCampaignStatController@export')->name('stat.campaign.export');
  Route::get('/stat/export/download/{id}', 'ScheduleCampaignStatController@exportDownload')->name('stat.campaign.export.download');
  Route::get('/detail/stat/campaign/{id}/{type?}/{view?}', 'ScheduleCampaignStatController@getDetailStat')->name('detail.stat.campaign');
  Route::get('/campaign/opens', 'ScheduleCampaignStatController@getOpens')->name('campaign.opens');
  Route::get('/campaign/clicks', 'ScheduleCampaignStatController@getClicks')->name('campaign.clicks');
  Route::get('/campaign/unsubscribed', 'ScheduleCampaignStatController@getUnsubscribed')->name('campaign.unsubscribed');
  Route::get('/campaign/bounces', 'ScheduleCampaignStatController@getBounces')->name('campaign.bounces');
  Route::get('/campaign/spam', 'ScheduleCampaignStatController@getSpam')->name('campaign.spam');
  Route::get('/campaign/logs', 'ScheduleCampaignStatController@getLogs')->name('campaign.logs');
  Route::get('/campaign/sent/{id}/{type?}', 'ScheduleCampaignStatController@getSentData')->name('campaign.sent.data');

  // Stats Drips
  Route::get('/stats/drips', 'ScheduleDripStatController@index')->name('stats.drips.index');
  Route::get('/get_stats_drips', 'ScheduleDripStatController@getStatsDrips')->name('stats.drips');
  Route::get('/detail/stat/drip/{id}/{type?}/{view?}', 'ScheduleDripStatController@getDetailStat')->name('detail.stat.drip');
  Route::get('/stat/drip/export/{id}', 'ScheduleDripStatController@export')->name('stat.drip.export');
  Route::get('/stat/drip/export/download/{id}', 'ScheduleDripStatController@exportDownload')->name('stat.drip.export.download');
  Route::get('/drip/sent/{id}/{type?}', 'ScheduleDripStatController@getSentData')->name('drip.sent.data');
  Route::get('/drip/opens', 'ScheduleDripStatController@getOpens')->name('drip.opens');
  Route::get('/drip/clicks', 'ScheduleDripStatController@getClicks')->name('drip.clicks');
  Route::get('/drip/unsubscribed', 'ScheduleDripStatController@getUnsubscribed')->name('drip.unsubscribed');
  Route::get('/drip/bounces', 'ScheduleDripStatController@getBounces')->name('drip.bounces');
  Route::get('/drip/spam', 'ScheduleDripStatController@getSpam')->name('drip.spam');
  Route::get('/drip/logs', 'ScheduleDripStatController@getLogs')->name('drip.logs');
  

  // Stats Auto Followup
  Route::get('/stats/auto_followups', 'AutoFollowupStatController@index')->name('stats.auto_followups.index');
  Route::get('/get_stats_auto_followups', 'AutoFollowupStatController@getAutoFollowups')->name('stats.auto_followups');
  Route::get('/detail/stat/auto_followup/{id}/{type?}/{view?}', 'AutoFollowupStatController@getDetailStat')->name('detail.stat.auto_followup');
  Route::get('/stat/auto_followup/export/{id}', 'AutoFollowupStatController@export')->name('stat.auto_followup.export');
  Route::get('/stat/auto_followup/export/download/{id}', 'AutoFollowupStatController@exportDownload')->name('stat.auto_followup.export.download');
  Route::get('/auto_followup/sent/{id}/{type?}', 'AutoFollowupStatController@getSentData')->name('auto_followup.sent.data');
  Route::get('/auto_followup/opens', 'AutoFollowupStatController@getOpens')->name('auto_followup.opens');
  Route::get('/auto_followup/clicks', 'AutoFollowupStatController@getClicks')->name('auto_followup.clicks');
  Route::get('/auto_followup/unsubscribed', 'AutoFollowupStatController@getUnsubscribed')->name('auto_followup.unsubscribed');
  Route::get('/auto_followup/bounces', 'AutoFollowupStatController@getBounces')->name('auto_followup.bounces');
  Route::get('/auto_followup/spam', 'AutoFollowupStatController@getSpam')->name('auto_followup.spam');
  Route::get('/auto_followup/logs', 'AutoFollowupStatController@getLogs')->name('auto_followup.logs');

  // Stats Triggers
  Route::get('/stats/triggers', 'TriggerStatController@index')->name('stats.triggers.index');
  Route::get('/get_stats_triggers', 'TriggerStatController@getTriggers')->name('stats.triggers');

  // PowerMTA
  Route::get('pmta', 'PmtaController@index')->name('pmta.index');
  Route::post('pmta_steps/{step?}', 'PmtaController@pmtaSteps');
  Route::get('/download/pmta/{name}', 'PmtaController@download')->name('download.pmta');

  // Emails Blacklist
  Route::get('/global_bounced', 'EmailsBlacklistController@globalBounced')->name('global.bounced.index');
  Route::get('/get_global_bounced', 'EmailsBlacklistController@getGlobalBounced')->name('global.bounced');
  Route::delete('/global_bounced/{id}', 'EmailsBlacklistController@destroyGlobalBounced')->name('global.bounced.destroy');
  Route::any('/global/bounced/import', 'EmailsBlacklistController@importBounced')->name('global.bounced.import');
  Route::get('/global/bounced/export', 'EmailsBlacklistController@exportBounced')->name('global.bounced.export');
  
  Route::get('/global_spam', 'EmailsBlacklistController@globalSpam')->name('global.spam.index');
  Route::get('/get_global_spam', 'EmailsBlacklistController@getGlobalSpam')->name('global.spam');
  Route::delete('/global_spam/{id}', 'EmailsBlacklistController@destroyGlobalSpam')->name('global.spam.destroy');

  Route::get('/blacklisted_ips', 'EmailsBlacklistController@blacklistedIPs')->name('blacklisted.ips.index');
  Route::get('/get_blacklisted_ips', 'EmailsBlacklistController@getblacklistedIPs')->name('blacklisted.ips');
  Route::get('/blacklisted_domains', 'EmailsBlacklistController@blacklistedDomains')->name('blacklisted.domains.index');
  Route::get('/get_blacklisted_domains', 'EmailsBlacklistController@getblacklistedDomains')->name('blacklisted.domains');
  Route::get('/blacklisted_detail/{id}', 'EmailsBlacklistController@blacklistedDetail')->name('blacklisted.detail');
});

// without Auth route
Route::group(['middleware' => ['language']], function () {
  Route::get('/page/{slug}/{contact_id?}', 'PageController@showPage')->name('page.show');
  Route::get('/contact/confirm/{id}', 'ContactController@confirm')->name('contact.confirm');
  Route::get('/contact/unsub/{id}', 'ContactController@unsub')->name('contact.unsub');
  Route::get('/process_campaign/{id?}/{thread_no?}', 'ScheduleCampaignController@processCampaign');
  Route::any('/webform_save_data', 'WebformController@saveWebFormData')->name('webform.save.data');
});

// No Middleware

// Campaign
Route::get('/open/{id}', 'TrackingController@openSchedule');
Route::get('/click/{id}/{url}', 'TrackingController@clickSchedule');
// Drip
Route::get('/d/open/{id}', 'TrackingController@openScheduleDrip');
Route::get('/d/click/{id}/{url}', 'TrackingController@clickScheduleDrip');
// Auto Followup
Route::get('/af/open/{id}', 'TrackingController@openAutoFollwoup');
Route::get('/af/click/{id}/{url}', 'TrackingController@clickAutoFollowup');
// Installation
Route::post('/installation', 'InstallController@installation');
Route::get('/ok', function(){
  return response()->json(['success' => 'success'], 200);
});

// Callbacks
Route::prefix('callback')->group(function () {
  // any to return success
  Route::any('amazon', 'CallbackController@amazon');
  Route::any('mailgun', 'CallbackController@mailgun');
  Route::any('sendgrid', 'CallbackController@sendGrid');
  Route::any('mailjet', 'CallbackController@mailjet');
  Route::any('elasticemail', 'CallbackController@elasticEmail');
});