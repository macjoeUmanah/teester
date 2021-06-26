@extends('layouts.app')
@section('title', __('app.edit_scheduled_drip'))
@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script>
  $('#lists').multiselect({
    includeSelectAllOption: true,
    enableFiltering: true,
    buttonWidth: '100%',
    numberDisplayed: 10,
    nonSelectedText: "{{ __('app.none_selected') }}"
  });
  $('#sending-servers').multiselect({
    enableFiltering: true,
    buttonWidth: '100%',
    nonSelectedText: "{{ __('app.none_selected') }}"
  });
</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_scheduled_drip') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.drips') }}</li>
    <li><a href="{{ route('scheduled.drips.index') }}">{{ __('app.schedule_drips') }}</a></li>
    <li class="active">{{ __('app.edit_scheduled_drip') }}</li>
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
              <input type="" class="form-control" name="name" value="{{ $scheduled->name }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }}<span class="required">*</span></label>
          <div class="col-md-6"> 
            <div class="input-group from-group">
              <label class="form-control">{{ $scheduled->group->name }}</label>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_group') }}"></i>
              </div>
            </div>
            
            <input type="hidden" name="drip_group_id" value="{{ $scheduled->group->id }}">
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.lists') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $list_ids = explode(',', $scheduled->list_ids) @endphp
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_lists') }}"></i>
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
          </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $sending_server_id = $scheduled->sending_server_id @endphp
              @include('includes.one_select_dropdown_sending_server')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_sending_server') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.send_to_existing') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="send_to_existing" class="form-control">
                <option value="Yes" {{ $scheduled->send_to_existing == 'Yes' ? 'selected' : '' }}>{{ __('app.yes') }}</option>
                <option value="No" {{ $scheduled->send_to_existing == 'No' ? 'selected' : '' }}>{{ __('app.no') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_send_to_existing') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('schedule_drip.update', ['id' => $scheduled->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
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
