@extends('layouts.app')
@section('title', __('app.settings_application'))

@section('scripts')
<script src="{{asset('public/components/bootstrap-filestyle/src/bootstrap-filestyle.min.js')}}"></script>
<script>
$(function(){
  loadSendingServerAttributes($("#type").val(), 'edit',0);
})
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.application_settings') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.settings') }}</li>
    <li class="active">{{ __('app.settings_application') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <!-- form start -->
    <form class="form-horizontal" name="settings" enctype="multipart/form-data">
      @csrf
      <div class="box-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab_settings_application">{{ __('app.application_settings') }}</a></li>
          <li><a data-toggle="tab" href="#tab_settings_general">{{ __('app.tab_settings_general') }}</a></li>
          <li><a data-toggle="tab" href="#tab_settings_mail">{{ __('app.tab_settings_mail') }}</a></li>
          <li><a data-toggle="tab" href="#tab_settings_tracking">{{ __('app.tab_settings_tracking') }}</a></li>
          <li><a data-toggle="tab" href="#tab_settings_permissions">{{ __('app.permissions') }}</a></li>
        </ul>

        <div class="tab-content" style="padding: 10px;">
          <div id="tab_settings_application" class="tab-pane fade in active">
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.license_key') }}</label>
              <div class="col-md-6">
                <label class="form-control">{{ $settings->license_key }}</label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.server_ip') }}</label>
              <div class="col-md-6" data-toggle="tooltip">
                <label class="form-control">{{ $_SERVER['SERVER_ADDR'] }}</label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.system_cron') }}</label>
              <div class="col-md-6" data-toggle="tooltip">
                <label class="form-control" style="font-size: 13px;">{{ \Helper::getCronCommand() }}</label>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.app_url') }}<span class="required">*</span></label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <input type="text" class="form-control" name="app_url" value="{{ $settings->app_url }}" placeholder="{{ __('app.mailcarry_url') }}">
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.app_url') }}"></i>
                  </div>
                </div>
                
              </div>
              <span></span>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.app_name') }}<span class="required">*</span></label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <input type="text" class="form-control" name="app_name" value="{{ $settings->app_name }}" placeholder="{{ __('app.mailcarry') }}">
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.app_name') }}"></i>
                  </div>
                </div>
              </div>
              <span></span>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.login_background_color') }}</label>
              <div class="col-md-6" data-toggle="tooltip" title="{{ __('help.login_page_image') }}">
                <div class="input-group from-group col-md-12">
                  <input type="text" class="form-control" name="login_backgroud_color" id="login-background-color" value="{{ !empty(json_decode($settings->attributes)->login_backgroud_color) ? json_decode($settings->attributes)->login_backgroud_color : '#dedede' }}" placeholder="#dedede">
                  <div class="input-group-addon input-group-addon-right">
                    <input type="color" value="{{ !empty(json_decode($settings->attributes)->login_backgroud_color) ? json_decode($settings->attributes)->login_backgroud_color : '#dedede' }}" onchange="$('#login-background-color').val(this.value)" style="height: 18px;">
                  </div>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.login_background_color') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.top_left_html') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <textarea class="form-control" rows="5" name="top_left_html" rows="8" placeholder="{{ __('app.top_left_html') }}">{{ !empty(json_decode($settings->attributes)->top_left_html) ? json_decode($settings->attributes)->top_left_html : '' }}</textarea>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.top_left_html') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.login_html') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <textarea class="form-control" rows="5" name="login_html" rows="8" placeholder="{{ __('app.login_html') }}">{{ !empty(json_decode($settings->attributes)->login_html) ? json_decode($settings->attributes)->login_html : '' }}</textarea>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.login_html') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.login_image') }}</label>
              <div class="col-md-6" data-toggle="tooltip" title="{{ __('help.login_page_image') }}">
                <div class="input-group from-group col-md-12">
                  <input type="file" id="file" name="file" class="form-control filestyle" data-buttonText="{{ __('app.login_page_image') }}" data-buttonBefore="true">
                  <div class="input-group-addon input-group-addon-right">
                    <a href="javascript:;"><i class="fa fa-eraser text-danger" id="clear" title="{{__('app.clear')}}"></i></a>
                  </div>
                  <div class="input-group-addon input-group-addon-right">
                    <a href="{{ json_decode($settings->attributes)->login_image }}" target="_blank"><i class="fa fa-eye text-success" title="{{__('app.view')}}"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tab_settings_general" class="tab-pane fade">
            <div class="form-group">
              <div class="col-md-offset-2 col-md-6">
                {!! \Helper::getMaxFileSize() !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.max_upload_file_size') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <input type="number" class="form-control" name="max_file_size" value="{{ !empty(json_decode($settings->general_settings)->max_file_size) ?  json_decode($settings->general_settings)->max_file_size : \Helper::getMaxFileSize(true)}}" placeholder="{!! \Helper::getMaxFileSize(true) !!}" max="{!! \Helper::getMaxFileSize(true) !!}" min="1">
                  <div class="input-group-addon input-group-addon-right">MB</div>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.max_upload_file_size') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.bounced_recipients') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <select name="bounced_recipients" class="form-control" >
                    <option value="none" {{ !empty(json_decode($settings->general_settings)->bounced_recipients) &&  json_decode($settings->general_settings)->bounced_recipients == 'none' ? 'selected' : ''}}>{{ __('app.none') }}</option>
                    <option value="unsub" {{ !empty(json_decode($settings->general_settings)->bounced_recipients) &&  json_decode($settings->general_settings)->bounced_recipients == 'unsub' ? 'selected' : ''}}>{{ __('app.recipients_option_unsub') }}</option>
                    <option value="inactive" {{ !empty(json_decode($settings->general_settings)->bounced_recipients) &&  json_decode($settings->general_settings)->bounced_recipients == 'inactive' ? 'selected' : ''}}>{{ __('app.recipients_option_inactive') }}</option>
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounced_recipients') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.spam_recipients') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <select name="spam_recipients" class="form-control" >
                    <option value="none" {{ !empty(json_decode($settings->general_settings)->spam_recipients) &&  json_decode($settings->general_settings)->spam_recipients == 'none' ? 'selected' : ''}}>{{ __('app.none') }}</option>
                    <option value="unsub" {{ !empty(json_decode($settings->general_settings)->spam_recipients) &&  json_decode($settings->general_settings)->spam_recipients == 'unsub' ? 'selected' : ''}}>{{ __('app.recipients_option_unsub') }}</option>
                    <option value="inactive" {{ !empty(json_decode($settings->general_settings)->spam_recipients) &&  json_decode($settings->general_settings)->spam_recipients == 'inactive' ? 'selected' : ''}}>{{ __('app.recipients_option_inactive') }}</option>
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.spam_recipients') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.suppressed_recipients') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <select name="suppressed_recipients" class="form-control" >
                    <option value="none" {{ !empty(json_decode($settings->general_settings)->suppressed_recipients) &&  json_decode($settings->general_settings)->suppressed_recipients == 'none' ? 'selected' : ''}}>{{ __('app.none') }}</option>
                    <option value="unsub" {{ !empty(json_decode($settings->general_settings)->suppressed_recipients) &&  json_decode($settings->general_settings)->suppressed_recipients == 'unsub' ? 'selected' : ''}}>{{ __('app.recipients_option_unsub') }}</option>
                    <option value="inactive" {{ !empty(json_decode($settings->general_settings)->suppressed_recipients) &&  json_decode($settings->general_settings)->suppressed_recipients == 'inactive' ? 'selected' : ''}}>{{ __('app.recipients_option_inactive') }}</option>
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.suppressed_recipients') }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tab_settings_mail" class="tab-pane fade">
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.sending_type') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <select name="type" id="type" class="form-control" >
                    @foreach(\Helper::sendingServers() as $type => $value)
                      <option value="{{ $type }}" {{ $type == $settings->sending_type ? 'selected="selected"' : '' }}>{{ $value }}</option>
                    @endforeach
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.settings_sending_server') }}"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.from_email') }}<span class="required">*</span></label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="from_email" value="{{ $settings->from_email ?? ''}}" placeholder="{{ __('app.from_email') }}">
              </div>
              <span></span>
            </div>
            <div id="sending-attributes"></div>
          </div>
          <div id="tab_settings_tracking" class="tab-pane fade">
            @if(!file_exists(config('mc.path_maxmind_geo_db')))
            <div class="col-md-offset-1 text-danger">
              {!! str_replace('[path]', config('mc.path_maxmind_geo_db'), __('app.geo_file_missing_msg')) !!}
              <br>
              {!! str_replace('[path]', config('mc.path_maxmind_geo_db'), __('app.geo_file_download_msg')) !!}
            </div>
            @endif
            <div class="form-group">
              <label class="col-md-2 control-label">{{ __('app.geo_tracking') }}</label>
              <div class="col-md-6">
                <div class="input-group from-group">
                  <select name="tracking" class="form-control">
                    <option value="enabled" {{ ($settings->tracking == 'enabled') ? 'selected' : '' }}>{{ __('app.enabled') }}</option>
                    <option value="disabled" {{ ($settings->tracking == 'disabled') ? 'selected' : '' }}>{{ __('app.disabled') }}</option>
                  </select>
                  <div class="input-group-addon input-group-addon-right">
                    <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.settings_tracking') }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tab_settings_permissions" class="tab-pane fade">
            @php $main_dir = base_path().DIRECTORY_SEPARATOR; @endphp
            <div class="panel panel-default">
              <div class="panel-heading">
                 <h3 class="panel-title">{{ __('app.permissions') }}</h3>
              </div>
              <div class="panel-body">

                <div class="col-md-12"><label>Files & Folders</label></div>
                <?php $bootstrap_folder = $main_dir.'bootstrap'.DIRECTORY_SEPARATOR.'cache'; ?>
                <label class="col-md-3 control-label">
                  <?php echo DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."cache &nbsp;&nbsp;&nbsp;
                  <small>
                    (should be 777 recursively) <br>
                    chmod 777 -R $bootstrap_folder
                  </small>"; ?>
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                    
                    $bootstrap_folder_permissions = substr(sprintf('%o', fileperms($bootstrap_folder)), -4);
                    echo $bootstrap_folder_permissions >= '0777' ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <?php $storage_folder = $main_dir.'storage'; ?>
                <label class="col-md-3 control-label">
                  <?php echo DIRECTORY_SEPARATOR."storage &nbsp;&nbsp;&nbsp;
                  <small>
                    (must be 777 recursively) <br>
                    chmod 777 -R $storage_folder
                  </small>"; ?>
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                    
                    $storage_folder_permissions = substr(sprintf('%o', fileperms($storage_folder)), -4);
                    echo $storage_folder_permissions >= '0777' ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>

                <div class="col-md-12"><label>PHP Extensions</label></div>
                <label class="col-md-3 control-label">
                  PHP >= 7.1.3
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo version_compare(PHP_VERSION, "7.1.3") > 0  ? '<i class="fa fa-check green-check"><small>'.PHP_VERSION.'</small></i>' : '<i class="fa fa-times red-times"><small>'.PHP_VERSION.'</small></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  PDO
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('PDO') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  openssl
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('openssl') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>

                <label class="col-md-3 control-label">
                  curl
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('curl') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  mbstring
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('mbstring') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  tokenizer
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('tokenizer') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>


                <label class="col-md-3 control-label">
                  xml
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('xml') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  imap
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('imap') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
                <label class="col-md-3 control-label">
                  zip
                </label>
                <div class="col-md-1 control-label" style="text-align: left;">
                  <?php
                  echo extension_loaded ('zip') ? '<i class="fa fa-check green-check"></i>' : '<i class="fa fa-times red-times"></i>';
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('settings.update') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- /.box-body -->
</section>
<!-- /.content -->
@endsection
