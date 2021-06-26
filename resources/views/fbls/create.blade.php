<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_fbl') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.status') }}</label>
          <div class="col-md-8">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" checked="checked">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="email" class="form-control" name="email" value="" placeholder="{{ __('app.fbl_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_email') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_method') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="method" class="form-control">
                <option value="imap">IMAP</option>
                <option value="pop3">POP3</option>
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_method') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_host') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="host" value="" placeholder="{{ __('app.fbl_host') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_host') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_username') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="username" value="" placeholder="{{ __('app.fbl_username') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_username') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_password') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="password" class="form-control" name="password" value="" placeholder="{{ __('app.fbl_password') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_password') }}"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_port') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="number" min="0" class="form-control" name="port" value="" placeholder="{{ __('app.fbl_port') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_port') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.fbl_encryption') }}</label>
          <div class="col-md-8">
            <div class="input-group from-group">
             <select name="encryption" id="groups" class="form-control">
              <option value="none">None</option>
              <option value="ssl" selected="selected">SSL</option>
              <option value="tls">TLS</option>
            </select>
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_encryption') }}"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.fbl_validate_cert') }}</label>
        <div class="col-md-8">
          <div class="input-group from-group">
            <select name="validate_cert" id="groups" class="form-control">
              <option value="Yes">{{ __('app.yes') }}</option>
              <option value="No">{{ __('app.no') }}</option>
            </select>
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_cert') }}"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.fbl_delete_after_processing') }}</label>
        <div class="col-md-8">
          <div class="input-group from-group">
            <select name="delete_after_processing" id="groups" class="form-control">
              <option value="No">{{ __('app.no') }}</option>
              <option value="Yes">{{ __('app.yes') }}</option>
            </select>
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.fbl_delete') }}"></i>
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
    <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('fbl.store') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
    <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('fbl.store') }}', 1);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
  </div>
</form>
</div>