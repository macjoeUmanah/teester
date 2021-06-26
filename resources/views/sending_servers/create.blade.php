@extends('layouts.app')
@section('title', __('app.add_new_sending_server'))
@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/custom.js')}}"></script>
@if(!empty(Input::get('type')))<script>loadSendingServerAttributes("{{Input::get('type')}}", 'create');</script>
@endif

<script>
// Already call in custom.js so need to write here to overwrite
function spinTags(key) {
  $('#from-name').val($('#from-name').val() + key);
  toastr.success('Copied successfully!');
}
</script>
@endsection
@section('content')
<section class="content-header">
  <h1>{{ __('app.add_new_sending_server') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li><a href="{{ route('sending_servers.index') }}">{{ __('app.setup_sending_servers') }}</a></li>
    <li class="active">{{ __('app.add_new_sending_server') }}</li>
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
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
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
                  <option value="{{ $id }}">{{ Helper::decodeString($group_name) }}</option>
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
              <input type="text" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
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
            <div class="input-group from-group">
              <select name="type" id="type" class="form-control" >
                @foreach(\Helper::sendingServers() as $type => $value)
                  <option value="{{ $type }}" {{ (!empty(Input::get('type')) && Input::get('type') == $type) ? 'selected="selected"' : '' }}>{{ $value }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_type') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div id="sending-attributes"></div>
        <div class="form-group">
          <label class="col-md-2 control-label"><input type="text" id="shortcode" value="" style="background: #fff; border:#fff; width:1px;"><a tabindex="-1" href="javascript:;" onclick="viewModal('modal', '{{ route('shortcodes', ['section'=>'spintags']) }}');">{{ __('app.shortcodes') }}</a> &nbsp;{{ __('app.from_name') }} <span class="required">*</span></label>
          <div class="col-md-6">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="from_name" id="from-name" value="" placeholder="{{ __('app.from_name') }}">
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
              <input type="text" class="form-control" name="from_email_part1" value="" placeholder="{{ __('app.from_email_placeholder') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_from_email') }}"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3" style="padding-left: 0px;">
            <div class="input-group from-group">
              <div class="input-group-addon input-group-addon-left">
                <i class="fa fa-at"></i>
              </div>
              <select name="from_email_part2" class="form-control">
                <option value="">{{ __('app.none') }}</option>
                @foreach($sending_domains as $sending_domain)
                  <option value="{{ $sending_domain->domain }}">{{ $sending_domain->domain }}</option>
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
              <input type="text" class="form-control" name="reply_email" value="" placeholder="{{ __('app.reply_email') }}">
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
               <select name="bounce_id" id="bounce-id" class="form-control">
                <option value="0">{{ __('app.none') }}</option>
                @foreach($bounces as $bounce)
                  <option value="{{ $bounce->id }}">{{ $bounce->email }}</option>
                @endforeach
              </select>
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
                  <option value="{{ $sending_domain->protocol }}{{ $sending_domain->tracking }}.{{ $sending_domain->domain }}">{{ $sending_domain->protocol }}{{ $sending_domain->tracking }}.{{ $sending_domain->domain }}</option>
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
                <option value="Unlimited">{{ __('app.unlimited') }}</option>
                <option value="Limited">{{ __('app.limited') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_server_speed') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" id="speed-attributes" style="display: none;">
          <div class="col-md-offset-2 col-md-3">
            <input type="number" class="form-control" name="limit" value="">
          </div>
          <div class="col-md-3"> 
            <select name="duration" class="form-control" >
              <option value="hourly">{{ __('app.hourly') }}</option>
              <option value="daily">{{ __('app.daily') }}</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('sending_server.store') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
            <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('sending_server.store') }}', 1)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
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
