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
loadBasedOnData('list', 'create');
loadBasedOnAction('send_campaign', 'create');
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.triggers') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li><a href="{{ route('triggers.index') }}">{{ __('app.triggers') }}</a></li>
    <li class="active">{{ __('app.create_trigger') }}</li>
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
          <div class="col-md-2" data-toggle="tooltip" title="{{ __('help.trigger_status') }}">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
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
                <option value="now">{{ __('app.now') }}</option>
                <option value="later">{{ __('app.later') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_run') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="send-datetime" style="display: none;">
          <label class="col-md-2 control-label">{{ __('app.start_datetime') }}</label>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="send_date_execute" class="form-control datepicker">
            </div>
          </div>
          <div class="col-md-3 bootstrap-timepicker" style="padding-left: 0px;"> 
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="send_time_execute" class="form-control timepicker">
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
              <select name="based_on" id="based-on-trigger" class="form-control" >
                  <option value="list">{{ __('app.trigger_based_on_list') }}</option>
                  <option value="segment">{{ __('app.trigger_based_on_segment') }}</option>
                  <option value="date">{{ __('app.trigger_based_on_date') }}</option>
              </select>
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
                <option value="unlimited">{{ __('app.unlimited') }}</option>
                <option value="limited">{{ __('app.limited') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_speed') }}"></i>
              </div>
            </div>
            
          </div>
        </div>
        <div class="form-group" id="speed-attributes" style="display: none;">
          <div class="col-md-offset-2 col-md-3">
            <input type="number" class="form-control" name="sending_limit" value="" min="1" placeholder="100">
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
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('trigger.store') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
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
