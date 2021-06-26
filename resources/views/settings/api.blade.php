@extends('layouts.app')
@section('title', __('app.settings_api'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script>
$(function() {
  $('.btn-submit').click(function() {
    swal({
      title: "{{__('app.api_msg_regenerate')}}",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      closeOnConfirm: false
    }, function (isConfirm) {
      if(isConfirm) {
        $("#frm-api").submit(); 
      }
    });
  });
})
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.settings_api') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.settings') }}</li>
    <li class="active">{{ __('app.settings_api') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" id="frm-api" action="{{ route('settings.api') }}" method="post">
      @csrf
      @method('PUT')
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.status') }}</label>
          <div class="col-md-6">
            <a href="#" data-toggle="tooltip" title="{{ __('help.api_active') }}">
              <input type="checkbox" id="active-api" data-route="{{route('settings.api.status')}}" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $user->api == 'Enabled' ? 'checked="checked"' : '' }}>
            </a>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.api_key') }}</label>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" class="form-control" name="api_key" id="api-key" value="{{ $user->api_token }}" readonly="readonly">
              <div class="input-group-addon input-group-addon-right">
                <a href="javascript:;"><i class="fa fa-copy" id="copy-api-token"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-primary btn-submit">{{ __('app.regenerate') }}</button>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.api_base_url') }}</label>
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" class="form-control" id="api-base-url" value="{{ \Helper::getAppURL() }}/api/v1" readonly="readonly">
              <div class="input-group-addon input-group-addon-right">
                <a href="javascript:;"><i class="fa fa-copy" id="copy-api-url"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-6">
            <div class="input-group">
              <a href="https://mailcarry.com/api/" target="_blank">{{__('app.api_documentation_help') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
</section>
<!-- /.content -->
@endsection
