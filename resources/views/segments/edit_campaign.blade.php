@extends('layouts.app')
@section('title', __('app.add_new_segment_by_campaign'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
@endsection

@php
 $segment_attributes =  json_decode($segment->attributes);
@endphp

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<script type="text/javascript">
getSetmentAttributes('edit', "{{$segment_attributes->action_segment ?? ''}}", "{{$segment->id ?? ''}}");
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.add_new_segment_by_campaign') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li><a href="{{ route('segments.index') }}">{{ __('app.automation_segments') }}</a></li>
    <li class="active">{{ __('app.add_new_segment_by_campaign') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- form start -->
  <form class="form-horizontal" id="frm-segment">
    <div class="box box-default">
      @csrf
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.segment_name') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
               <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($segment->name) }}" placeholder="{{ __('app.segment_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.schedules') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $schedule_campaign_stat_ids = $segment_attributes->schedule_campaign_stat_ids; @endphp
              @include('includes.multi_select_dropdown_schedule_campaign')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_campaigns') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.action') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
             <select id="segment-action" name="action_segment" class="form-control">
                <option value="both" {{ $segment_attributes->action_segment == 'both' ? 'selected="selected"' : '' }}>{{ __('app.segment_both_open_not_open') }}</option>
                <option value="is_opened" {{ $segment_attributes->action_segment == 'is_opened' ? 'selected="selected"' : '' }}>{{ __('app.is_opened') }}</option>
                <option value="is_not_opened" {{ $segment_attributes->action_segment == 'is_not_opened' ? 'selected="selected"' : '' }}>{{ __('app.is_not_opened') }}</option>
                <option value="is_clicked" {{ $segment_attributes->action_segment == 'is_clicked' ? 'selected="selected"' : '' }}>{{ __('app.is_clicked') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_action') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div id="attributes"></div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <input type="hidden" name="type" value="{{ $by }}">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{ route('segment.update', ['id' => $segment->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
          </div>
        </div>
      </div>
    </div>
  </form>

</section>
<!-- /.content -->
@endsection