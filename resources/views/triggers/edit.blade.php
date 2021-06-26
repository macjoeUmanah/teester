@extends('layouts.app')
@section('title', __('app.triggers'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<script>
$(function () {
  $("#action").change(function() {
    loadBasedOnAction($("#action").val(), 'edit', '{{$trigger->id}}');
  });
});
loadBasedOnData('{{$trigger->based_on}}', 'edit', '{{$trigger->id}}');
loadBasedOnAction('{{$trigger->action}}', 'edit', '{{$trigger->id}}');
</script>
@endsection
@php $attributes = json_decode($trigger->attributes); @endphp
@section('content')
<section class="content-header">
  <h1>{{ __('app.triggers') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li><a href="{{ route('triggers.index') }}">{{ __('app.triggers') }}</a></li>
    <li class="active">{{ __('app.edit_trigger') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <form class="form-horizontal" id="frm-group">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-6" data-toggle="tooltip" title="{{ __('help.trigger_status') }}">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $trigger->active == 'Yes' ? 'checked="checked"' : ''}}>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($trigger->name) ?? ''}}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.run') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="execute" id="send" class="form-control">
                <option value="now" {{!empty($attributes->execute) && $attributes->execute == 'now' ? 'selected' : ''}}>{{ __('app.now') }}</option>
                <option value="later" {{!empty($attributes->execute) && $attributes->execute == 'later' ? 'selected' : ''}}>{{ __('app.later') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_run') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="send-datetime" style="display: {{!empty($attributes->execute) && $attributes->execute == 'now' ? 'none;' : ''}}">
          <label class="col-md-2 control-label">{{ __('app.start_datetime') }}</label>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="send_date_execute" value="{{$attributes->send_date_execute ?? ''}}" class="form-control datepicker">
            </div>
          </div>
          <div class="col-md-3 bootstrap-timepicker" style="padding-left: 0px;"> 
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="send_time_execute" value="{{$attributes->send_time_execute ?? ''}}" class="form-control timepicker">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_execute_date_time') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.based_on') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <label class="form-control">{{ ucfirst($trigger->based_on) }}</label>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_based_on') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div id="based-on-data"></div>
        <div id="action-data"></div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_server') }}
            <a href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $sending_server_ids = json_decode($trigger->sending_server_ids); @endphp
              @include('includes.multi_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_sending_servers') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_speed') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="sending_speed" id="speed" class="form-control" >
                <option value="unlimited" {{!empty($attributes->sending_speed) && $attributes->sending_speed == 'unlimited' ? 'selected' : ''}}>{{ __('app.unlimited') }}</option>
                <option value="limited" {{!empty($attributes->sending_speed) && $attributes->sending_speed == 'limited' ? 'selected' : '' }}>{{ __('app.limited') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_speed') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="speed-attributes" style="{{$attributes->sending_speed == 'unlimited' ? 'display: none' : ''}}">
          <div class="col-md-offset-2 col-md-3">
            <input type="number" class="form-control" name="sending_limit" value="{{$attributes->sending_limit ?? '' }}" min="1">
          </div>
          <div class="col-md-3"> 
            <select name="duration" class="form-control" >
              <option value="hour">{{ __('app.hourly') }}</option>
            </select>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('trigger.update',  ['id' => $trigger->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
          </div>
        </div>
      </div>
    </form>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<!-- /.content -->
@endsection