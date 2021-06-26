@extends('layouts.app')
@section('title', __('app.edit_user'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_user') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li><a href="{{ route('users.index') }}">{{ __('app.users') }}</a></li>
    <li class="active">{{ __('app.edit_user') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-user" name="user" method="post" action="{{ route('user.update', ['id' => $user->id]) }}">
      @csrf
      <div class="box-body">
        @if($user->id != config('mc.superadmin'))
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-6">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $user->active == 'Yes' ? 'checked="checked"' : ''}}>
          </div>
        </div>
        @endif
        @if(!$profile)
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.role') }}<span class="required">*</span></label>
          <div class="col-md-6">
            @if($profile)
              <label class="form-control">{{ $user->role->name }}</label>
            @else
              <div class="input-group from-group">
              <select name="role_id" class="form-control">
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ ($role->id == $user->role_id) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <a href="{{$user->role_id != 1 ? route('roles_permissions.permissions', ['id' => $user->role_id]) : '#' }}">
                  <i class="fa fa-eye" data-toggle="tooltip" title="{{ __('help.view_permissions') }}"></i>
                </a>
              </div>
            </div>
            @endif
          </div>
          <span></span>
        </div>
        @endif
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($user->name) }}" placeholder="{{ __('app.name') }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.email') }} <span class="required">*</span></label>
          <div class="col-md-6">
            @if($user->id == config('mc.superadmin') && $user->email == 'admin@mailcarry.com')
            <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="{{ __('app.email') }}">
            @else
            <label class="form-control">{{ $user->email }}</label>
            @endif
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.password') }}</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="password" placeholder="{{ __('app.leave_blank') }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.confirm_password') }}</label>
          <div class="col-md-6">
            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('app.confirm_password') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.address') }}</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="address" value="{{ Helper::decodeString($user->address) }}" placeholder="{{ __('app.address') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.country') }}</label>
          <div class="col-md-6">
            <select name="country_code" class="form-control">
              @foreach(\Helper::countries() as $code => $name)
                <option value="{{ $code }}" {{ ($code == $user->country_code) ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.phone') }}</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="phone" value="{{ Helper::decodeString($user->phone) }}" placeholder="{{ __('app.phone') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.time_zone') }}</label>
          <div class="col-md-6">
            <select name="time_zone" class="form-control">
              @foreach(\Helper::timeZones() as $key => $time_zone)
                <option value="{{ $key }}" {{ ($key == $user->time_zone) ? 'selected' : '' }}>{{ $time_zone }} {{$user->timezone}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.language') }}</label>
          <div class="col-md-6">
            <select name="language" class="form-control">
              @foreach(\Helper::languages() as $key => $language)
                <option value="{{ $key }}" {{ ($key == $user->language) ? 'selected' : '' }}>{{ $language }}</option>
              @endforeach
            </select>
          </div>
        </div>
        @if($profile && $user->is_client)
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.lists') }}</label>
          <div class="col-md-6">
            <label class="form-control">{{ $client['lists'] }}</label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.setup_sending_servers') }}</label>
          <div class="col-md-6">
            <label class="form-control">{{ $client['sending_servers'] }}</label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.no_of_recipients') }}</label>
          <div class="col-md-6">
            <label class="form-control">{{ $client['no_of_recipients'] }}</label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.no_of_sending_servers') }}</label>
          <div class="col-md-6">
            <label class="form-control">{{ $client['no_of_sending_servers'] }}</label>
          </div>
        </div>
        @endif
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('user.update', ['id' => $user->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-default" onclick="exit()">{{ __('app.exit') }}</button>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </form>
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
@endsection
