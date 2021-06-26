<script>
$(function(){
  'use strict';
  $('#copy-callback-url').click(function() {
    document.getElementById("callback-url").select();
    document.execCommand("copy");
    toastr.success('Copied successfully!');
  });
  $('#process-reports').change(function() {
    $('.div-webhook-url').toggle('slow');
  });
});
</script>
@if($type == 'smtp')
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_host') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="host" value="{{ $action == 'edit' && !empty($data->host) ? Helper::decodeString($data->host) : '' }}" placeholder="{{ __('app.smtp_host') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_username') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="username" value="{{ $action == 'edit' && !empty($data->username) ? $data->username : '' }}" placeholder="{{ __('app.smtp_username') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_password') }}</label>
    <div class="col-md-6">
      <input type="password" class="form-control" name="password" value="{{ $action == 'edit' && !empty($data->password) ? '#########' : '' }}" placeholder="{{ __('app.smtp_password') }}">
    </div>
    <input type="hidden" name="smtpid" value="{{ $action == 'edit' && !empty($data->password) ? $data->password : '' }}">
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_port') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="port" value="{{ $action == 'edit' && !empty($data->port) ? $data->port : '' }}" placeholder="{{ __('app.smtp_port') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_encryption') }}</label>
    <div class="col-md-6">
      <select name="encryption" class="form-control" >
        <option value="none" {{ $action == 'edit' && $data->encryption == 'none' ? 'selected="selected"' : '' }}>{{ __('app.none') }}</option>
        <option value="ssl" {{ $action == 'edit' && $data->encryption == 'ssl' ? 'selected="selected"' : '' }}>SSL</option>
        <option value="tls" {{ $action == 'edit' && $data->encryption == 'tls' ? 'selected="selected"' : '' }}>TLS</option>
      </select>
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.smtp_body_encoding') }}</label>
    <div class="col-md-6">
      <select name="body_encoding" class="form-control" >
        <option value="quoted-printable" {{ $action == 'edit' && !empty($data->body_encoding) && $data->body_encoding == 'quoted-printable' ? 'selected="selected"' : '' }}>quoted-printable</option>
        <option value="base64" {{ $action == 'edit' && !empty($data->body_encoding) && $data->body_encoding == 'base64' ? 'selected="selected"' : '' }}>base64</option>
        <option value="7-bit" {{ $action == 'edit' && !empty($data->body_encoding) && $data->body_encoding == '7-bit' ? 'selected="selected"' : '' }}>7-bit</option>
      </select>
    </div>
    <span></span>
  </div>
@elseif($type == 'amazon_ses_api')
@php $section='amazon'; @endphp
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.amazon_access_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="access_key" value="{{ $action == 'edit' && !empty($data->access_key) ? $data->access_key : '' }}" placeholder="{{ __('app.amazon_access_key') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.amazon_secret_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="secret_key" value="{{ $action == 'edit' && !empty($data->secret_key) ? \Crypt::decrypt($data->secret_key) : '' }}" placeholder="{{ __('app.amazon_secret_key') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.amazon_region') }}</label>
    <div class="col-md-6">
      <select name="region" class="form-control">
        @foreach(\Helper::amazonRegions() as $region_key => $region)
          <option value="{{ $region_key }}" {{ $action == 'edit' && $data->region == $region_key ? 'selected="selected"' : '' }}>{{ $region }}</option>
        @endforeach
      </select>
    </div>
    <span></span>
  </div>
@elseif($type == 'mailgun_api')
@php $section='mailgun'; @endphp
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.mailgun_domain') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="domain" value="{{ $action == 'edit' && !empty($data->domain) ? $data->domain : '' }}" placeholder="{{ __('app.mailgun_domain') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.mailgun_api_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.mailgun_api_key') }}">
    </div>
    <span></span>
  </div>
@elseif($type == 'sparkpost_api')
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.sparkpost_api_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.sparkpost_api_key') }}">
    </div>
    <span></span>
  </div>
@elseif($type == 'sendgrid_api')
@php $section='sendgrid'; @endphp
    <div class="form-group">
      <label class="col-md-2 control-label">{{ __('app.sendgrid_api_key') }} <span class="required">*</span></label>
      <div class="col-md-6">
        <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.sendgrid_api_key') }}">
      </div>
      <span></span>
    </div>
@elseif($type == 'mandrill_api')
    <div class="form-group">
      <label class="col-md-2 control-label">{{ __('app.mandrill_api_key') }} <span class="required">*</span></label>
      <div class="col-md-6">
        <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.mandrill_api_key') }}">
      </div>
      <span></span>
    </div>
@elseif($type == 'elastic_email_api')
@php $section='elasticemail'; @endphp
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.elastic_email_account_id') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="account_id" value="{{ $action == 'edit' && !empty($data->account_id) ? $data->account_id : '' }}" placeholder="{{ __('app.elastic_email_account_id') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.elastic_email_api_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.elastic_email_api_key') }}">
    </div>
    <span></span>
  </div>
@elseif($type == 'mailjet_api')
@php $section='mailjet'; @endphp
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.mailjet_api_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? $data->api_key : '' }}" placeholder="{{ __('app.mailjet_api_key') }}">
    </div>
    <span></span>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.mailjet_secret_key') }} <span class="required">*</span></label>
    <div class="col-md-6">
      <input type="text" class="form-control" name="secret_key" value="{{ $action == 'edit' && !empty($data->secret_key) ? \Crypt::decrypt($data->secret_key) : '' }}" placeholder="{{ __('app.mailjet_secret_key') }}">
    </div>
    <span></span>
  </div>
@elseif($type == 'sendinblue_api')
    <div class="form-group">
      <label class="col-md-2 control-label">{{ __('app.sendinblue_api_key') }} <span class="required">*</span></label>
      <div class="col-md-6">
        <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.sendinblue_api_key') }}">
      </div>
      <span></span>
    </div>
@endif


@if($type == 'mailgun_api' || $type == 'sendgrid_api' || $type == 'mailjet_api' || $type == 'elastic_email_api' || $type == 'amazon_ses_api')
  <div class="form-group">
    <label class="col-md-2 control-label">{{ __('app.process_reports') }}</label>
    <div class="col-md-6">
      <select name="process_reports" id="process-reports" class="form-control" >
        <option value="no" {{ $action == 'edit' && !empty($data->process_reports) && $data->process_reports == 'no' ? 'selected="selected"' : '' }}>{{ __('app.no') }}</option>
        <option value="yes" {{ $action == 'edit' && !empty($data->process_reports) && $data->process_reports == 'yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
      </select>
    </div>
  </div>
@endif

@if($type == 'mailgun_api' || $type == 'sendgrid_api' || $type == 'mailjet_api' || $type == 'elastic_email_api')
  <div class="form-group div-webhook-url" style="{{ $action == 'edit' && !empty($data->process_reports) && $data->process_reports == 'yes' ? '' : 'display:none' }}">
    <label class="col-md-2 control-label">{{ __('app.webhook_url') }}</label>
    <div class="col-md-6">
      <div class="input-group from-group">
        <input type="text" class="form-control" name="callback_url" id="callback-url" value="{{Helper::getAppURL()}}/callback/{{$section}}" readonly="readonly">
        <div class="input-group-addon input-group-addon-right">
          <a href="javascript:;"><i class="fa fa-copy" id="copy-callback-url"></i></a>
        </div>
        <div class="input-group-addon input-group-addon-right">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('callback.help', [$section]) }}')"><i class="fa fa-info-circle"></i></a>
        </div>
      </div>
    </div>
  </div>
@elseif($type == 'amazon_ses_api')
  <div class="form-group div-webhook-url" style="{{ $action == 'edit' && !empty($data->process_reports) && $data->process_reports == 'yes' ? '' : 'display:none' }}">
    <label class="col-md-2 control-label">{{ __('app.webhook_url') }}</label>
    <div class="col-md-6">
      <div class="input-group from-group">
        <input type="text" class="form-control" name="callback_url" id="callback-url" value="{{Helper::getAppURL()}}/callback/{{$section}}" readonly="readonly">
        <div class="input-group-addon input-group-addon-right">
          <a href="javascript:;"><i class="fa fa-copy" id="copy-callback-url"></i></a>
        </div>
        <div class="input-group-addon input-group-addon-right">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('callback.help', [$section]) }}')"><i class="fa fa-info-circle"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group div-webhook-url" style="{{ $action == 'edit' && !empty($data->process_reports) && $data->process_reports == 'yes' ? '' : 'display:none' }}">
    <label class="col-md-2 control-label">{{ __('app.amazon_configuration_set') }}</label>
    <div class="col-md-6">
      <div class="input-group from-group">
        <input type="text" class="form-control" name="amazon_configuration_set" value="{{$data->amazon_configuration_set ?? ''}}">
        <div class="input-group-addon input-group-addon-right">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('callback.help', [$section]) }}')"><i class="fa fa-info-circle"></i></a>
        </div>
      </div>
    </div>
  </div>
@endif