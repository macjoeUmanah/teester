<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ $bounce->email }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.status') }}</label>
          <div class="col-md-8">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $bounce->active == 'Yes' ? 'checked="checked"' : ''}}>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_name') }}</label>
          <div class="col-md-8">
            <label class="form-control">{{ $bounce->email }}</label>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_method') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="method" class="form-control">
                <option value="imap" {{ $bounce->method == 'imap' ? 'selected="selected"' : '' }}>IMAP</option>
                <option value="pop3" {{ $bounce->method == 'pop3' ? 'selected="selected"' : '' }}>POP3</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_method') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_host') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="host" value="{{ Helper::decodeString($bounce->host) }}" placeholder="{{ __('app.bounce_host') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_host') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_username') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="username" value="{{ $bounce->username }}" placeholder="{{ __('app.bounce_username') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_username') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_password') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="password" class="form-control" name="password" value="{{ !empty($bounce->password) ? Crypt::decrypt($bounce->password) : '' }}" placeholder="{{ __('app.bounce_password') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_password') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_port') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="number" min="0" class="form-control" name="port" value="{{ $bounce->port }}" placeholder="{{ __('app.bounce_port') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_port') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_encryption') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="encryption" class="form-control">
                <option value="none" {{ $bounce->encryption == 'none' ? 'selected="selected"' : '' }}>None</option>
                <option value="ssl" {{ $bounce->encryption == 'ssl' ? 'selected="selected"' : '' }}>SSL</option>
                <option value="tls" {{ $bounce->encryption == 'tls' ? 'selected="selected"' : '' }}>TLS</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_encryption') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_validate_cert') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="validate_cert" class="form-control">
                <option value="Yes" {{ $bounce->validate_cert == 'Yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
                <option value="No" {{ $bounce->validate_cert == 'No' ? 'selected="selected"' : '' }}>{{ __('app.no') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_cert') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.bounce_delete_after_processing') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="delete_after_processing" class="form-control">
                <option value="No" {{ $bounce->delete_after_processing == 'No' ? 'selected="selected"' : '' }}>{{ __('app.no') }}</option>
                <option value="Yes" {{ $bounce->delete_after_processing == 'Yes' ? 'selected="selected"' : '' }}>{{ __('app.yes') }}</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.bounce_delete') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-8" id="imap-msg"></div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="validateImap(this, this.form)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.validate') }}">{{ __('app.validate') }}</button>
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('bounce.update', ['id' => $bounce->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
    </div>
  </form>
</div>