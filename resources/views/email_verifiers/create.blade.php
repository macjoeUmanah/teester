<link rel="stylesheet" href="{{asset('public/components/bootstrap-toggle/css/bootstrap-toggle.min.css')}}">
<script src="{{asset('public/components/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>
<script src="{{asset('public/js/common.js')}}"></script>
<script>loadEmailVerifiersAttributes('kickbox', 'create');</script>
<div class="modal-content">
  <form class="form-horizontal" id="frm">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_email_verifier') }}</h4>
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
          <label class="col-md-3 control-label">{{ __('app.name') }} <span class="required">*</span></label>
          <div class="col-md-8">
            <div class="input-group from-group">
              <input type="name" class="form-control" name="name" value="" placeholder="{{ __('app.name') }}">
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
              <select name="type" id="type-email-verifier" class="form-control" >
                @foreach(\Helper::emailVerifiers() as $type => $value)
                <option value="{{ $type }}">{{ $value }}</option>
                @endforeach
              </select>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.email_verifiers_type') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div id="email_verifiers-attributes"></div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('email_verifier.store') }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('email_verifier.store') }}', 1);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save_add_new') }}">{{ __('app.save_add_new') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button>
    </div>
  </form>
</div>