<!-- Header -->
<header class="main-header">
  <!-- Logo -->
  <a href="{{route('dashboard')}}" class="logo dashboard-logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{!! !empty(json_decode($settings->attributes)->top_left_html) ? json_decode($settings->attributes)->top_left_html : '' !!}</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{!! !empty(json_decode($settings->attributes)->top_left_html) ? json_decode($settings->attributes)->top_left_html : '' !!}</span>
  </a>
  <nav class="navbar navbar-static-top">
    @if(!empty(Auth::user()->id))
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
      <span class="top-bar-timezone">
        <span id="time_zone" style="display: none;">{{isset($time_zone) ? $time_zone : 'Europe/London'}}</span>
        <div id="clock"></div>
      </span>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{ !empty(count($notifications)) ? count($notifications) : '' }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{ str_replace('[number]', count($notifications), __('app.you_have_notifications')) }} <span class="padding-left-10"> <a href="{{ route('notification.read.all') }}" class="text-danger">{{ __('app.clear_all') }}</a></span></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($notifications as $notification)
                    @switch($notification->type)
                      @case('export')
                        @php ($icon = 'fa-download')
                        @php ($title = __('app.download'))
                        @break
                      @case('import')
                        @php ($icon = 'fa-check')
                        @php ($title = '')
                        @break
                      @default
                        @php ($icon = 'fa fa-bell-o')
                        @php ($title = '')
                    @endswitch
                    <li>
                      <a title="{{ $title }}" href="{{ route('notification.read', ['id' => $notification->id]) }}">
                        <i class="fa {{ $icon }}"></i> {{ $notification->name}}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </li>
            </ul>
          </li>
          <!-- /.notifications -->
          <!-- User: -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span>{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu" style="width: 25px;">
              <li class="header"><a href="{{ route('profile') }}">{{ __('app.profile') }}</a></li>
              <li class="header">
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  {{ __('app.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
          <!-- /.user -->
        </ul>
      </div>
    @endif
  </nav>
</header>
@if(Session::has('impersonate'))
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12 text-center">
    <div class="alert alert-danger-light">
      <i class="icon fa fa-warning"></i>
      {!! __('app.msg_impersonate') !!} <strong>{{ Auth::user()->name }}</strong>
      <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <font class="profil-logout">
          {{ __('app.logout') }}
        </font>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
        @csrf
      </form>
      <span class="padding-left-right-20"><strong>OR</strong></span>
      {{ __('app.back_to') }}<a href="{{ route('user.impersonate', ['id' => config('mc.app_id')]) }}"><font class="profil-logout">{{ __('app.superadmin') }}</font></a>
    </div>
  </div>
</div>
@endif