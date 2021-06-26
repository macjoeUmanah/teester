@extends('layouts.app')
@section('title', __('app.tools_update'))

@section('scripts')
<script src="{{asset('public/js/update.js')}}"></script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.tools_update') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.tools') }}</li>
    <li class="active">{{ __('app.tools_update') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <form class="form-horizontal" name="settings" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-md-8 col-md-offset-2 {{ $settings->msg_text_color }} font-26">{{ $settings->msg }}</label>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Current Version</label>
          <div class="col-md-6"><span class="form-control">{{ $settings->current_version }}</span></div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Latest Available Version</label>
          <div class="col-md-6"><span class="form-control">{{ $settings->available_version }}</span></div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.license_key') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <input type="text" class="form-control" id="license_key" name="license_key" value="{{ $settings->license_key }}" placeholder="{{ __('app.license_key') }}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-md-offset-2">
            <button id="btn-update" type="button" class="btn btn-primary loader" data-route="{{ route('app.update.proceed') }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.update') }}" {{$settings->available_version < $settings->current_version ? 'disabled' : ''}}>{{ __('app.update') }}</button>
          </div>
          <div class="col-md-7"><a href="https://mailcarry.com/change-log" target="_blank" class="font-22">Change Log</a></div>
        </div>
        <div class="row">
          <div class="col-md-5 col-md-offset-2" id="msg"></div>
        </div>
      </div>
    </form>
    <!-- /.box-body -->
  </div>
</section>
<span id="update-proceed-msg" data-value="{{ __('app.update_proceed_msg') }}"></span>
<span id="update-warning-msg" data-value="{{ __('app.update_warning_msg') }}"></span>
<!-- /.content -->
@endsection
