<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('public/js/custom.js')}}">
<script src="{{asset('public/js/multiselect.js')}}"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.timepicker').timepicker({
      showInputs: false
    });
    var date = new Date();
    date.setDate(date.getDate());
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      startDate: date
    });
    $("#action").change(function() {
      var type = $("#action").val();
      @if($action == 'create')
        loadBasedOnAction(type, 'create');
      @endif
    });
    $("#trigger-start").change(function() {
      if(this.value == 'after_event'){
        $("#trigger-start-duration").show('slow');
      } else {
        $("#trigger-start-duration").hide('slow');
      }
    });
  });
</script>
@php
  if($action == 'edit') {
    $attributes = json_decode($trigger->attributes);
  }
@endphp

@if($type == 'list' || $type == 'date')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.lists') }}
    <a href="{{ route('list.create') }}">
      <i class="fa fa-plus-square-o"></i>
    </a>
    <span class="required">*</span>
  </label>
  <div class="col-md-6">
    <div class="input-group from-group">
      @php
      if($action == 'edit') {
        $list_ids = $attributes->list_ids ?? null;
      }
      @endphp
      @include('includes.multi_select_dropdown_list')
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_lists') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@if($type == 'list' || $type == 'date')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.contact') }} <span class="required">*</span>
  </label>
  <div class="col-md-6">
    <div class="input-group from-group">
      @if($action == 'create')
        <select name="based_on_action" class="form-control">
          <option value="only_newly_added">{{ __('app.only_newly_added') }}</option>
          <option value="all_previous_newly_added">{{ __('app.all_previous_newly_added') }}</option>
        </select>
      @else
        <label class="form-control">{{ ucwords(str_replace('_', ' ', str_replace('all_previous_newly_added','all_previously_&_newly_added',$attributes->based_on_action) )) }}</label>
        <input type="hidden" name="based_on_action" value="{{$attributes->based_on_action}}">
      @endif
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_based_on_list_action') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@endif

@elseif($type == 'segment')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.segment') }}
    <a tabindex="-1" href="{{ route('segments.index') }}">
      <i class="fa fa-plus-square-o"></i>
    </a>
  </label>
  <div class="col-md-6">
    <div class="input-group from-group">
      @php
      if($action == 'edit') {
        $segment_id = $attributes->segment_id ?? null;
      }
      @endphp
      @include('includes.one_select_dropdown_segment')
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_segment') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
<input type="hidden" name="based_on_action" value="all_previous_newly_added">
@endif

@if($type == 'date')
<div class="form-group" id="send-datetime">
  <label class="col-md-2 control-label">{{ __('app.datetime') }}</label>
  <div class="col-md-3">
    <div class="input-group">
      <div class="input-group-addon input-group-addon-left">
        <i class="fa fa-calendar"></i>
      </div>
      <input type="text" name="send_date" value="{{ $attributes->send_date ?? '' }}" class="form-control datepicker">
    </div>
  </div>
  <div class="col-md-3 bootstrap-timepicker" style="padding-left: 0px;"> 
    <div class="input-group from-group">
      <div class="input-group-addon input-group-addon-left">
        <i class="fa fa-clock-o"></i>
      </div>
      <input type="text" name="send_time" value="{{ $attributes->send_time ?? '' }}" class="form-control timepicker">
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_send_date_time') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@endif


@if($type == 'segment')
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.action') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <div class="input-group from-group">
        @if($action == 'create')
          <select name="action" id="action" class="form-control" >
              <option value="send_campaign">{{ __('app.send_campaign') }}</option>
          </select>
        @else
          <label class="form-control">{{ ucwords(str_replace('_', ' ', $trigger->action)) }}</label>
        @endif
        <div class="input-group-addon input-group-addon-right">
          <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_action') }}"></i>
        </div>
      </div>
    </div>
    <span></span>
  </div>
@elseif($type == 'list' || $type == 'date')
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.action') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <div class="input-group from-group">
        @if($action == 'create')
        <select name="action" id="action" class="form-control" >
            <option value="send_campaign">{{ __('app.send_campaign') }}</option>
            <option value="start_drip">{{ __('app.start_drip') }}</option>
        </select>
        @else
          <label class="form-control">{{ ucwords(str_replace('_', ' ', $trigger->action)) }}</label>
        @endif
        <div class="input-group-addon input-group-addon-right">
          <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_action') }}"></i>
        </div>
      </div>
    </div>
    <span></span>
  </div>
@endif


@if($type == 'send_campaign')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.broadcast') }}
    <a href="{{ route('broadcast.create') }}">
      <i class="fa fa-plus-square-o"></i>
    </a>
    <span class="required">*</span>
  </label>
  <div class="col-md-6">
    <div class="input-group from-group">
      @php
      if($action == 'edit') {
        $broadcast_id = $attributes->broadcast_id ?? null;
      }
      @endphp
      @include('includes.one_select_dropdown_broadcast')
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_broadcast') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@elseif($type == 'start_drip')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.drip_group') }} 
  </label></label>
  <div class="col-md-6">
    <div class="input-group from-group">
      <select name="drip_group_id" id="groups" class="form-control">
        <option value="">{{ __('app.none') }}</option>
        @foreach(\App\Models\Group::groups(config('mc.groups.drips')) as $id => $name)
        <option value="{{ $id }}" {{$action == 'edit' && !empty($attributes->drip_group_id) && $attributes->drip_group_id == $id ? 'selected' : ''}}>{{ $name }}</option>
        @endforeach
      </select>
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_drip') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@endif

@if($type == 'send_campaign')
<div class="form-group">
  <label class="col-md-2 control-label">{{ __('app.trigger_start') }}</label>
  <div class="col-md-6">
    <div class="input-group from-group">
      <select name="trigger_start" id="trigger-start" class="form-control">
        <option value="instant" {{$action == 'edit' && $attributes->trigger_start == 'instant' ? 'selected' : ''}}>{{ __('app.instant') }}</option>
        <option value="after_event" {{$action == 'edit' && $attributes->trigger_start == 'after_event' ? 'selected' : ''}}>{{ __('app.after_event') }}</option>
      </select>
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_start') }}"></i>
      </div>
    </div>
  </div>
</div>
<div class="form-group" id="trigger-start-duration" style="display: {{$action == 'create' ? 'none' : ($action == 'edit' && $attributes->trigger_start == 'instant' ? 'none' : 'block')}};">
  <label class="col-md-2 control-label">{{ __('app.trigger_start_duration') }} <span class="required">*</span></label>
  <div class="col-md-3">
    <input type="input" class="form-control" name="trigger_start_limit" value="{{ $attributes->trigger_start_limit ?? '' }}">
  </div>
  <div class="col-md-3"> 
    <div class="input-group from-group">
      <select name="trigger_start_duration" class="form-control" >
        <option value="minutes" {{$action == 'edit' && $attributes->trigger_start_duration == 'minutes' ? 'selected' : ''}}>{{ __('app.minutes') }}</option>
        <option value="hours" {{$action == 'edit' && $attributes->trigger_start_duration == 'hours' ? 'selected' : ''}}>{{ __('app.hours') }}</option>
        <option value="days" {{$action == 'edit' && $attributes->trigger_start_duration == 'days' ? 'selected' : ''}}>{{ __('app.days') }}</option>
      </select>
      <div class="input-group-addon input-group-addon-right">
        <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.trigger_start_duration') }}"></i>
      </div>
    </div>
  </div>
  <span></span>
</div>
@endif