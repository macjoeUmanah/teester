@extends('layouts.app')
@section('title', __('app.edit_sending_server'))
@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/custom.js')}}"></script>
<script>
$("#modal").on("hidden.bs.modal", function () {
  dropdownDB('bounce-id', "{{route('get_bounces', ['return_type' => 'json'])}}");
});
$(function(){
  loadSendingServerAttributes($("#type").val(), 'edit', '{{ $sending_server->id}}');
  $("#speed").val() == 'Limited' ? $("#speed-attributes").show() : '';
});
// Already call in custom.js so need to write here to overwrite
function spinTags(key) {
  $('#from-name').val($('#from-name').val() + key);
  toastr.success('Copied successfully!');
}

</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.edit_sending_server') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li><a href="{{ route('sending_servers.index') }}">{{ __('app.setup_sending_servers') }}</a></li>
    <li class="active">{{ __('app.edit_sending_server') }}</li>
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
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-6">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $sending_server->status == 'Active' ? 'checked="checked"' : '' }}>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.group') }} <span class="required">*</span>
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('group.create', ['type_id' => config('mc.groups.sending_server')]) }}');">
              <i class="fa fa-plus-square-o"></i>
            </a>
            </label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="group_id" id="groups" class="form-control">
                @foreach($groups as $id => $group_name)
                  <option value="{{ $id }}" {{ $id == $sending_server->group_id ? 'selected="selected"' : '' }}>{{ Helper::decodeString($group_name) }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_group') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($sending_server->name) }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.type') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <select name="type" id="type" class="form-control" disabled="disabled" >
              @foreach(\Helper::sendingServers() as $type => $value)
                <option value="{{ $type }}" {{ $type == $sending_server->type ? 'selected="selected"' : '' }}>{{ $value }}</option>
              @endforeach
            </select>
            <input type="hidden" name="type" value="{{ $sending_server->type }}">
          </div>
          <span></span>
        </div>
        <div id="sending-attributes"></div>
        <div class="form-group">
          <label class="col-md-2 control-label"><input type="text" id="shortcode" value="" style="background: #fff; border:#fff; width:1px;"><a tabindex="-1" href="javascript:;" onclick="viewModal('modal', '{{ route('shortcodes', ['section'=>'spintags']) }}');">{{ __('app.shortcodes') }}</a> &nbsp;{{ __('app.from_name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
               <input type="text" class="form-control" id="from-name" name="from_name" value="{{ Helper::decodeString($sending_server->from_name) }}" placeholder="{{ __('app.from_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_from_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.from_email') }} <span class="required">*</span></label>
          <div class="col-md-3">
            <div class="input-group from-group">
               <input type="text" class="form-control" name="from_email_part1" value="{{ Helper::decodeString(strstr($sending_server->from_email, '@', true)) }}" placeholder="{{ __('app.from_email_placeholder') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_from_email') }}"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3" style="padding-left: 0px;">
            <div class="input-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-at"></i>
              </div>
              <select name="from_email_part2" class="form-control">
                <option value="">{{ __('app.none') }}</option>
                @foreach($sending_domains as $sending_domain)
                  <option value="{{ $sending_domain->domain }}" {{ strpos($sending_server->from_email, $sending_domain->domain) !== false ? 'selected="selected"' : '' }}>{{ $sending_domain->domain }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <a class="sending_domain" href="{{ route('sending_domains.index') }}"><i class="fa fa-plus-square-o"></i></a>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.reply_email') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
               <input type="text" class="form-control" name="reply_email" value="{{ $sending_server->reply_email }}" placeholder="{{ __('app.reply_email') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_reply_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.bounce_email') }}
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('bounce.create') }}');">
              <i class="fa fa-plus-square-o"></i></a></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              @if(empty($sending_server->bounce_id) && !empty($sending_server->pmta))
                <label class="form-control">{{__('app.bounce_pmta_file')}}</label>
                <input type="hidden" name="pmta_id" value="{{$sending_server->pmta}}">
              @else
                <select name="bounce_id" id="bounce-id" class="form-control">
                  <option value="0">{{ __('app.none') }}</option>
                  @foreach($bounces as $bounce)
                    <option value="{{ $bounce->id }}" {{ $bounce->id == $sending_server->bounce_id ? 'selected="selected"' : '' }}>{{ $bounce->email }}</option>
                  @endforeach
                </select>
                <input type="hidden" name="pmta_id" value="NULL">
              @endif
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_bounce') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.tracking_domain') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="tracking_domain" class="form-control">
                <option value="">{{ __('app.none') }}</option>
                @foreach($sending_domains as $sending_domain)
                  <option value="{{ $sending_domain->protocol }}{{ $sending_domain->tracking }}.{{ $sending_domain->domain }}" {{ !empty($sending_server->tracking_domain) && stripos( $sending_server->tracking_domain, $sending_domain->domain) !== false  ? 'selected="selected"' : '' }}>{{ $sending_domain->protocol }}{{ $sending_domain->tracking }}.{{ $sending_domain->domain }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_tracking_domain') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_speed') }}</label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <select name="speed" id="speed" class="form-control" >
                <option value="Unlimited" {{ json_decode($sending_server->speed_attributes)->speed == 'Unlimited' ? 'selected="selected"' : '' }}>{{ __('app.unlimited') }}</option>
                <option value="Limited" {{ json_decode($sending_server->speed_attributes)->speed == 'Limited' ? 'selected="selected"' : '' }}>{{ __('app.limited') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_speed') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="speed-attributes" style="display: none;">
          <div class="col-md-offset-2 col-md-3">
            <input type="number" class="form-control" name="limit" value="{{ json_decode($sending_server->speed_attributes)->limit }}">
          </div>
          <div class="col-md-3"> 
            <select name="duration" class="form-control" >
              <option value="hourly" {{ json_decode($sending_server->speed_attributes)->duration == 'hourly' ? 'selected="selected"' : '' }}>{{ __('app.hourly') }}</option>
              <option value="daily" {{ json_decode($sending_server->speed_attributes)->duration == 'daily' ? 'selected="selected"' : '' }}>{{ __('app.daily') }}</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'PUT', '{{ route('sending_server.update', ['id' => $sending_server->id]) }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-success" onclick="viewModal('modal', '{{ route('send.email', ['broadcast_id' => 0, 'sending_server_id' => $sending_server->id, 'template_id' => 0]) }}');">{{ __('app.send_test_email') }}</button>
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
