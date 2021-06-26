<script src="{{asset('public/js/common.js')}}"></script>
<div class="modal-content">
  <form class="form-horizontal" id="frm-group">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{ __('app.edit_spintag') }}</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.spintag_name') }} <span class="required">*</span></label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <input type="text" class="form-control" name="name" value="{{ Helper::decodeString($spintag->name) }}" placeholder="{{ __('app.custom_field_name') }}">
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.spintag_name') }}"></i>
              </div>
            </div>
          </div>
          <span></span>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">{{ __('app.spintag_values') }}</label>
          <div class="col-md-9">
            <div class="input-group from-group">
              <textarea class="form-control" name="values" rows="5" placeholder="{{ __('app.spintag_values_placehoder') }}">{{ Helper::decodeString($spintag->values) }}</textarea>
              <div class="input-group-addon input-group-addon-right">
                <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.spintag_values') }}"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
          <button type="button" class="btn btn-primary" onclick="submitData(this, this.form, 'PUT', '{{ route('spintag.update', ['id' => $spintag->id]) }}');" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.save') }}">{{ __('app.save') }}</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
        </div>
      </div>
    </div>
  </form>
</div>