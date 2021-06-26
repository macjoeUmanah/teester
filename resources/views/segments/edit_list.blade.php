@extends('layouts.app')
@section('title', __('app.edit_segment'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('public/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/jquery-repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('public/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/js/segment.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script>
  $('.repeater-contact').repeater({
    show: function () {
      $(this).slideDown();
    },
    hide: function (deleteElement) {
      if(confirm($('#repeater-delete-msg').data('value'))) {
        $(this).slideUp(deleteElement);
      }
    },
    isFirstItemUndeletable: true
  });
  $('.datetime').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
  });
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.segment') }} - {{ __('app.add_new_segment_by_list') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li><a href="{{ route('segments.index') }}">{{ __('app.automation_segments') }}</a></li>
    <li class="active">{{ __('app.add_new_segment_by_list') }}</li>
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
          <div class="col-md-6" data-toggle="tooltip" title="{{ __('help.segment_name') }}">
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
          <label class="col-md-2 control-label">{{ __('app.list') }}<span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @php $list_ids = json_decode($segment->attributes)->list_ids @endphp
              @include('includes.multi_select_dropdown_list')
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.segment_lists') }}"></i>
              </div>
            </div>
           
          </div>
          <span></span>
        </div>
      </div>
    </div>

    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.contact_filter') }}</h3>
      </div>
      <div class="box-body repeater-contact">
        <div data-repeater-list="contact_filter">
          @php $contact_filter = json_decode($segment->attributes)->contact_filter @endphp
          @foreach($contact_filter as $filter)
            <div data-repeater-item class="row" style="padding-top: 10px;">
              <div class="col-md-3">
                <select name="name" class="form-control" onchange="loadContactAction(this);">
                  <option value=""></option>
                  <option value="email" {{ $filter->name == 'email' ? 'selected' : '' }}>{{ __('app.email') }}</option>
                  <option value="status" {{ $filter->name == 'status' ? 'selected' : '' }}>{{ __('app.status') }}</option>
                  <option value="format" {{ $filter->name == 'format' ? 'selected' : '' }}>{{ __('app.format') }}</option>
                  <option value="source" {{ $filter->name == 'source' ? 'selected' : '' }}>{{ __('app.source') }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <select name="action" class="form-control">
                  <option value='is' {{ !empty($filter->action) &&  $filter->action == 'is' ? 'selected' : '' }}>is</option>
                  <option value='is_not' {{ !empty($filter->action) &&  $filter->action == 'is_not' ? 'selected' : '' }}>is not</option>
                  @if($filter->name == 'email')
                  <option value='contain' {{ !empty($filter->action) && $filter->action == 'contain' ? 'selected' : '' }}>contain</option>
                  <option value='not_contain' {{ !empty($filter->action) && $filter->action == 'not_contain' ? 'selected' : '' }}>doesn't</option>
                  @endif
                </select>
              </div>
              <div class="col-md-3">
                @if($filter->name == 'email')
                  <input type='text' class='form-control' placeholder='Use comma for multiples' name='value' value="{{ $filter->value }}">
                @else
                  <select name="value" class="form-control">
                    @if($filter->name == 'status')
                      <option value='active' {{ $filter->value == 'is_not' ? 'selected' : '' }}>Active</option>
                      <option value='inactive' {{ $filter->value == 'is_not' ? 'selected' : '' }}>Inactive</option>
                    @endif
                  </select>
                @endif
              </div>
              <div class="col-md-3">
                <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
              </div>
            </div>
          @endforeach
        </div>
        <div class="col-md-12 row" style="margin-top: 10px;">
          <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
        </div>
      </div>
    </div>

    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.custom_fields_filter') }}</h3>
      </div>
      <div class="box-body repeater-contact">
        <div data-repeater-list="custom_fields_filter">
          @php $custom_fields_filter = json_decode($segment->attributes)->custom_fields_filter @endphp
          @foreach($custom_fields_filter as $filter)
          <div data-repeater-item class="row" style="padding-top: 10px;">
            <div class="col-md-3">
              <select name="name" class="form-control">
                <option value=""></option>
                @if(!empty($custom_fields))
                  @foreach($custom_fields as $custom_field)
                    <option value="{{ $custom_field->id }}" {{ $filter->name == $custom_field->id ? 'selected' : '' }}>{{ Helper::decodeString($custom_field->name) }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <select name="action" class="form-control">
                <option value=""></option>
                <option value="is" {{ $filter->action == 'is' ? 'selected' : '' }}>is</option>
                <option value="is_not" {{ $filter->action == 'is_not' ? 'selected' : '' }}>is not</option>
                <option value="contain" {{ $filter->action == 'contain' ? 'selected' : '' }}>contain</option>
                <option value="not_contain" {{ $filter->action == 'not_contain' ? 'selected' : '' }}>doesn't</option>
              </select>
            </div>
            <div class="col-md-3">
              <input type="text" name="value" class="form-control" placeholder="Use comma for multiples" value="{{ Helper::decodeString($filter->value) }}">
            </div>
            <div class="col-md-3">
              <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
            </div>
          </div>
          @endforeach
        </div>
        <div class="col-md-12 row" style="margin-top: 10px;">
          <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
        </div>
      </div>
    </div>

    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">{{ __('app.dates_filter') }}</h3>
      </div>
      <div class="box-body repeater-contact">
        <div data-repeater-list="dates_filter">
          @php $dates_filter = json_decode($segment->attributes)->dates_filter @endphp
          @foreach($dates_filter as $filter)
          <div data-repeater-item class="row" style="padding-top: 10px;">
            <div class="col-md-3">
              <select name="name" class="form-control">
                <option value=""></option>
                <option value="subscription_date" {{ $filter->name == 'subscription_date' ? 'selected' : '' }}>Subscription Date</option>
                @if(!empty($custom_fields))
                  @foreach($custom_fields_date as $custom_field)
                    <option value="{{ $custom_field->id }}" {{ $filter->name == $custom_field->id ? 'selected' : '' }}>{{ Helper::decodeString($custom_field->name) }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <select name="action" class="form-control" onchange="loadDate(this)">
                <option value=""></option>
                <option value="is" {{ $filter->action == 'is' ? 'selected' : '' }}>is</option>
                <option value="is_not" {{ $filter->action == 'is_not' ? 'selected' : '' }}>is not</option>
                <option value="after" {{ $filter->action == 'after' ? 'selected' : '' }}>after</option>
                <option value="before" {{ $filter->action == 'before' ? 'selected' : '' }}>before</option>
              </select>
            </div>
            <div class="col-md-3">
              <input type="text" name="value" class="form-control datetime" value="{{ Helper::decodeString($filter->value) }}"">
            </div>
            <div class="col-md-3">
              <input data-repeater-delete type="button" class="btn btn-primary" value="Delete"/>
            </div>
          </div>
          @endforeach
        </div>
        <div class="col-md-12 row" style="margin-top: 10px;">
          <input data-repeater-create type="button" class="btn btn-primary" value="Add"/>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-offset-2 col-md-10">
        <input type="hidden" name="type" value="{{ $by }}">
        <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{ route('segment.update', ['id' => $segment->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
        <button type="button" class="btn btn-danger" onclick="exit()">{{ __('app.exit') }}</button>
      </div>
    </div>
  </form>

</section>
<!-- /.content -->
@endsection
