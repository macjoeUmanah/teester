<!-- Sidebar -->
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li {{ !empty($page) && $page == 'dashboard' ? 'class=active' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ __('app.dashboard') }}</span></a></li>
      @if(auth()->user()->can('lists') || auth()->user()->can('custom_fields') || auth()->user()->can('suppression') || auth()->user()->can('email_verifiers'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'list_') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-list"></i> <span>{{ __('app.lists') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('lists')
              <li {{ !empty($page) && $page == 'list_add_new' ? 'class=active' : '' }}><a href="{{ route('list.create') }}"><i class="fa"></i> {{ __('app.add_new_list') }}</a></li>
              <li {{ !empty($page) && $page == 'list_view_all' ? 'class=active' : '' }}><a href="{{ route('lists.index') }}"><i class="fa"></i> {{ __('app.view_manage') }}</a></li>
            @endcan
            @can('custom_fields')
              <li {{ !empty($page) && $page == 'list_custom_fields' ? 'class=active' : '' }}><a href="{{ route('custom_fields.index') }}"><i class="fa"></i> {{ __('app.custom_fields') }}</a></li>
            @endcan
            @can('bulk_update')
              <li {{ !empty($page) && $page == 'list_bulk_update' ? 'class=active' : '' }}><a href="javascript:;" onclick="viewModal('modal', '{{ route('bulk_update') }}')"><i class="fa"></i> {{ __('app.bulk_update') }}</a></li>
            @endcan
            @can('email_verifiers')
              <li {{ !empty($page) && $page == 'list_email_verifiers' ? 'class=active' : '' }}><a href="{{ route('email.verifiers.index') }}"><i class="fa"></i> {{ __('app.email_verifiers') }}</a></li>
            @endcan
            @can('suppression')
              <li {{ !empty($page) && $page == 'list_suppression' ? 'class=active' : '' }}><a href="{{ route('suppressions.index') }}"><i class="fa"></i> {{ __('app.setup_suppression') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('contacts') || auth()->user()->can('import_contacts'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'contact_') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-address-card-o"></i> <span>{{ __('app.contacts') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('contacts')
              <li {{ !empty($page) && $page == 'contact_add_new' ? 'class=active' : '' }}><a href="{{ route('contact.create') }}"><i class="fa"></i> {{ __('app.add_new_contact') }}</a></li>
              <li {{ !empty($page) && $page == 'contact_view_all' ? 'class=active' : '' }}><a href="{{ route('contacts.index') }}"><i class="fa"></i> {{ __('app.view_manage') }}</a></li>
            @endcan
            @can('import_contacts')
              <li {{ !empty($page) && $page == 'contact_import' ? 'class=active' : '' }}><a href="{{ route('contacts.import', ['id' => 0]) }}"><i class="fa"></i> {{ __('app.import_contacts') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('broadcasts') || auth()->user()->can('campaigns'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'campaign_') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-send-o"></i> <span>{{ __('app.campaigns') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('broadcasts')
              <li {{ !empty($page) && $page == 'campaign_create_broadcasts' ? 'class=active' : '' }}><a href="{{ route('broadcast.create') }}"><i class="fa"></i> {{ __('app.create_new') }}</a></li>
              <li {{ !empty($page) && $page == 'campaign_broadcasts' ? 'class=active' : '' }}><a href="{{ route('broadcasts.index') }}"><i class="fa"></i> {{ __('app.view_manage') }}</a></li>
            @endcan
            @can('campaigns')
              <li {{ !empty($page) && $page == 'campaign_schedules' ? 'class=active' : '' }}><a href="{{ route('scheduled.campaigns.index') }}"><i class="fa"></i> {{ __('app.schedules') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('drips') || auth()->user()->can('segments') || auth()->user()->can('spintags') || auth()->user()->can('triggers'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'automation_') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-gears"></i> <span>{{ __('app.automation') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('spintags')
              <li {{ !empty($page) && $page == 'automation_spintags' ? 'class=active' : '' }}><a href="{{ route('spintags.index') }}"><i class="fa"></i> {{ __('app.automation_spintags') }}</a></li>
            @endcan
            @can('segments')
              <li {{ !empty($page) && $page == 'automation_segments' ? 'class=active' : '' }}><a href="{{ route('segments.index') }}"><i class="fa"></i> {{ __('app.automation_segments') }}</a></li>
            @endcan
            @can('drips')
              <li {{ !empty($page) && $page == 'automation_drips' ? 'class=active' : '' }}><a href="{{ route('drips.index') }}"><i class="fa"></i> {{ __('app.drips') }}</a></li>
            @endcan
            @can('triggers')
              <li {{ !empty($page) && $page == 'automation_triggers' ? 'class=active' : '' }}><a href="{{ route('triggers.index') }}"><i class="fa"></i> {{ __('app.triggers') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(
        auth()->user()->can('sending_domains') || auth()->user()->can('sending_servers') || auth()->user()->can('pmta')
        || auth()->user()->can('bounces') || auth()->user()->can('fbl')
      )
        <li class="treeview {{!empty($page) &&  (strpos($page, 'setup') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-magic"></i> <span>{{ __('app.setup') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('sending_domains')
              <li {{ !empty($page) && $page == 'setup_sending_domains' ? 'class=active' : '' }}><a href="{{ route('sending_domains.index') }}"><i class="fa"></i> {{ __('app.setup_sending_domains') }}</a></li>
            @endcan
            @can('sending_servers')
              <li {{ !empty($page) && $page == 'setup_sending_servers' ? 'class=active' : '' }}><a href="{{ route('sending_servers.index') }}"><i class="fa"></i> {{ __('app.setup_sending_servers') }}</a></li>
            @endcan
            @can('pmta')
              <li {{ !empty($page) && $page == 'setup_pmta' ? 'class=active' : '' }}><a href="{{ route('pmta.index') }}"><i class="fa"></i> {{ __('app.setup_pmta') }}</a></li>
            @endcan
            @can('bounces')
              <li {{ !empty($page) && $page == 'setup_bounces' ? 'class=active' : '' }}><a href="{{ route('bounces.index') }}"><i class="fa"></i> {{ __('app.setup_bounces') }}</a></li>
            @endcan
            @can('fbl')
              <li {{ !empty($page) && $page == 'setup_fbl' ? 'class=active' : '' }}><a href="{{ route('fbls.index') }}"><i class="fa"></i> {{ __('app.setup_fbl') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('settings_application') || auth()->user()->can('settings_api'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'settings') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-gear"></i> <span>{{ __('app.settings') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('settings_application')
              <li {{ !empty($page) && $page == 'settings_application' ? 'class=active' : '' }}><a href="{{ route('settings') }}"><i class="fa"></i> {{ __('app.settings_application') }}</a></li>
            @endcan
            @can('settings_api')
              <li {{ !empty($page) && $page == 'settings_api' ? 'class=active' : '' }}><a href="{{ route('settings.api') }}"><i class="fa"></i> {{ __('app.settings_api') }}</a></li>
            @endcan
            @can('settings_mail_headers')
              <li {{ !empty($page) && $page == 'settings_mail_headers' ? 'class=active' : '' }}><a href="{{ route('settings.mail.headers') }}"><i class="fa"></i> {{ __('app.settings_mail_headers') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('templates') || auth()->user()->can('pages') || auth()->user()->can('web_forms'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'layouts') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-paint-brush"></i> <span>{{ __('app.layouts') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('web_forms')
              <li {{ !empty($page) && $page == 'layouts_webforms' ? 'class=active' : '' }}><a href="{{ route('webforms.index') }}"><i class="fa"></i> {{ __('app.setup_webforms') }}</a></li>
            @endcan
            @can('templates')
              <li {{ !empty($page) && $page == 'layouts_templates' ? 'class=active' : '' }}><a href="{{ route('templates.index') }}"><i class="fa"></i> {{ __('app.templates') }}</a></li>
            @endcan
            @can('pages')
              <li {{ !empty($page) && $page == 'layouts_pages' ? 'class=active' : '' }}><a href="{{ route('pages.index') }}"><i class="fa"></i> {{ __('app.pages_emails') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif
      @if(auth()->user()->can('stats_campaigns') || auth()->user()->can('stats_drips') || auth()->user()->can('stats_auto_followup') || auth()->user()->can('stats_triggers'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'stats') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>{{ __('app.stats') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('stats_campaigns')
              <li {{ !empty($page) && $page == 'stats_campaign' ? 'class=active' : '' }}><a href="{{ route('stats.campaigns.index') }}"><i class="fa"></i> {{ __('app.campaigns') }}</a></li>
            @endcan
            @can('stats_triggers')
              <li {{ !empty($page) && $page == 'stats_triggers' ? 'class=active' : '' }}><a href="{{ route('stats.triggers.index') }}"><i class="fa"></i> {{ __('app.triggers') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif

      @if(auth()->user()->can('blacklisted_ips') || auth()->user()->can('blacklisted_domains') || auth()->user()->can('global_spam') || auth()->user()->can('global_spam'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'blacklists_') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-ban"></i> <span>{{ __('app.blacklisted') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('blacklisted_ips')
              <li {{ !empty($page) && $page == 'blacklists_ips' ? 'class=active' : '' }}><a href="{{ route('blacklisted.ips.index') }}"><i class="fa"></i> {{ __('app.ips') }}</a></li>
            @endcan
            @can('blacklisted_domains')
              <li {{ !empty($page) && $page == 'blacklists_domains' ? 'class=active' : '' }}><a href="{{ route('blacklisted.domains.index') }}"><i class="fa"></i> {{ __('app.domains') }}</a></li>
            @endcan
            @can('global_bounced')
              <li {{ !empty($page) && $page == 'blacklists_bounced' ? 'class=active' : '' }}><a href="{{ route('global.bounced.index') }}"><i class="fa"></i> {{ __('app.global_bounced') }}</a></li>
            @endcan
            @can('global_spam')
              <li {{ !empty($page) && $page == 'blacklists_spam' ? 'class=active' : '' }}><a href="{{ route('global.spam.index') }}"><i class="fa"></i> {{ __('app.global_spam') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif

      @if(auth()->user()->can('users') || auth()->user()->can('roles') || auth()->user()->can('clients'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'user_management') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-users"></i> <span>{{ __('app.user_management') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('roles')
              <li {{ !empty($page) && $page == 'user_management_roles' ? 'class=active' : '' }}><a href="{{ route('roles_permissions.index') }}"><i class="fa"></i> {{ __('app.roles') }}</a></li>
            @endcan
            @can('packages')
              <li {{ !empty($page) && $page == 'user_management_packages' ? 'class=active' : '' }}><a href="{{ route('packages.index') }}"><i class="fa"></i> {{ __('app.packages') }}</a></li>
            @endcan
            @can('clients')
              <li {{ !empty($page) && $page == 'user_management_clients' ? 'class=active' : '' }}><a href="{{ route('clients.index') }}"><i class="fa"></i> {{ __('app.clients') }}</a></li>
            @endcan
            @can('users')
              <li {{ !empty($page) && $page == 'user_management_users' ? 'class=active' : '' }}><a href="{{ route('users.index') }}"><i class="fa"></i> {{ __('app.users') }}</a></li>
            @endcan
          </ul>
        </li>
      @endif

      @if(auth()->user()->can('image_manager') || auth()->user()->can('logs') || auth()->user()->can('backup') || auth()->user()->can('update'))
        <li class="treeview {{!empty($page) &&  (strpos($page, 'tools') !== false) ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-wrench"></i> <span>{{ __('app.tools') }}</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('image_manager')
              <li {{ !empty($page) && $page == 'tools_image_manager' ? 'class=active' : '' }}><a href="{{ route('images.manager') }}"><i class="fa"></i> {{ __('app.tools_images_manager') }}</a></li>
            @endcan
            @can('logs')
              <li {{ !empty($page) && $page == 'tools_logs' ? 'class=active' : '' }}><a href="{{ route('logs.index') }}"><i class="fa"></i> {{ __('app.tools_logs') }}</a></li>
            @endcan
            @can('backup')
              <li> <a href="javascript:;" onclick="viewModal('modal', '{{ route('backup') }}')"><i class="fa"></i> {{ __('app.tools_backup') }}</a></li>
            @endcan
            @can('update')
              <li {{ !empty($page) && $page == 'tools_update' ? 'class=active' : '' }}> <a href="{{ route('app.update') }}"><i class="fa"></i> {{ __('app.tools_update') }}</a></li>
            @endcan
          </ul>
      </li>
      @endif
    </ul>
  </section>
</aside>
<!-- /.sidebar -->