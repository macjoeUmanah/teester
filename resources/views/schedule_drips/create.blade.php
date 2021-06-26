@extends('layouts.app')
@section('title', __('app.schedule_new_drip'))
@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
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
  <h1>{{ __('app.schedule_new_drip') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.drips') }}</li>
    <li><a href="{{ route('scheduled.drips.index') }}">{{ __('app.schedule_drips') }}</a></li>
    <li class="active">{{ __('app.schedule_new_drip') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-schedule-drip">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }} 
          </label></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="drip_group_id" id="groups" class="form-control">
                <option value="">{{ __('app.none') }}</option>
                @foreach(\App\Models\Group::groups(config('mc.groups.drips')) as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.drip_schedule_group') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.lists') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
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
                <option value="Yes">{{ __('app.yes') }}</option>
                <option value="No">{{ __('app.no') }}</option>
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
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('schedule_drip.store') }}', 2)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_exit') }}">{{ __('app.save_add_exit') }}</button>
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
