<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<script>loadEmailVerifiersAttributes($("#type-email-verifier").val(), 'edit', '{{ $email_verifier->id}}');</script>
<div class="modal-content">
  <form class="form-horizontal" id="frm">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ $email_verifier->name }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.status') }}</label>
          <div class="col-md-8">
            <input type="checkbox" name="active" data-toggle="toggle" data-size="small" data-on="{{ __('app.active') }}" data-off="{{ __('app.inactive') }}" {{ $email_verifier->active == 'Yes' ? 'checked="checked"' : ''}}>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($email_verifier->name) }}" placeholder="{{ __('app.name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.type') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <select name="type"  class="form-control" disabled="disabled">
                @foreach(\Helper::emailVerifiers() as $type => $value)
                <option value="{{ $type }}" {{ $type == $email_verifier->type ? 'selected="selected"' : '' }}>{{ $value }}</option>
                @endforeach
              </select>
              <input type="hidden" name="type" id="type-email-verifier" value="{{ $email_verifier->type }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.email_verifiers_type') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div id="email_verifiers-attributes"></div>
        <div class="form-group">
          <label class="col-md-3 control-label">{{ __('app.email') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="from-group">
              <input type="email" class="form-control" name="email" value="" placeholder="{{ __('app.email') }}">
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-8">
            <input type="hidden" name="id" value="{{ $email_verifier->id }}">
            <button type="button" class="btn btn-success" onclick="verifyEmail(this, this.form)" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.verify') }}">{{ __('app.verify') }}</button>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-3 col-md-8" id="verify-msg"></div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('email_verifier.update', ['id' => $email_verifier->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>