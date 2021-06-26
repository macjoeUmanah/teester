<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.add_new_sending_domain') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.sending_domain_name') }} <span class="required">*</span></label>
          <div class="col-md-9">
            <div class="col-md-4">
              <select name="protocol" class="form-control">
                <option value="https://">https://</option>
                <option value="http://">http://</option>
              </select>
            </div>
            <div class="col-md-8">
              <div class="input-group from-group">
                <input type="text" class="form-control" name="domain" value="" placeholder="{{ __('app.example-domain') }}">
                <div class="input-group-addon input-group-addon-right">
                  <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.sending_domain_name') }}"></i>
                </div>
              </div>
            </div>
          </div>
          <span></span>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'POST', '{{ route('sending_domain.store') }}', 0, 1, 1);" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">{{ __('app.close') }}</button></a>
    </div>
  </form>
</div>