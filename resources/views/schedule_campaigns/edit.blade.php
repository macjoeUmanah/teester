@extends('layouts.app')
@section('title', __('app.schedule_new_campaign'))
@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('public/js/schedule.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.schedule_new_campaign') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.schedules') }}</li>
    <li><a href="{{ route('scheduled.campaigns.index') }}">{{ __('app.campaigns') }}</a></li>
    <li class="active">{{ __('app.schedule_new_campaign') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-sending-server">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($scheduled->name) }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.broadcast') }}
            <a href="{{ route('broadcast.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @include('includes.one_select_dropdown_broadcast')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_broadcast') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.lists') }}
            <a href="{{ route('list.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $list_ids = explode(',', $scheduled->list_ids) @endphp
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_lists') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_server') }}
            <a href="{{ route('sending_server.create') }}">
              <i class="fa fa-plus-square-o"></i>
            </a>
            <span class="required">*</span>
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $sending_server_ids = explode(',', $scheduled->sending_server_ids) @endphp
              @include('includes.multi_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_sending_servers') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.send') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="send" id="send" class="form-control">
                <option value="now">{{ __('app.now') }}</option>
                <option value="later">{{ __('app.later') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.schedule_send') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="send-datetime" style="display: none;">
          <label class="col-md-2 control-label">{{ __('app.sending_time') }}</label>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="send_date" class="form-control datepicker">
            </div>
          </div>
          <div class="col-md-3 bootstrap-timepicker" style="padding-left: 0px;"> 
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-clock-o"></i>
              </div>
              <input type="text" name="send_time" class="form-control timepicker">
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_speed') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="speed" id="speed" class="form-control" >
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
            <input type="number" class="form-control" name="limit" value="" min="1">
          </div>
          <div class="col-md-3"> 
            <select name="duration" class="form-control" >
              <option value="hour">{{ __('app.hourly') }}</option>
            </select>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('schedule_campaign.update', ['id' => $scheduled->id]) }}', 2)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_exit') }}">{{ __('app.save_add_exit') }}</button>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </form>
  </div>
  <!-- /.box -->
</section>
<div id="none-selected" data-value="{{ __('app.none_selected')}}"></div>
<!-- /.content -->
@endsection
