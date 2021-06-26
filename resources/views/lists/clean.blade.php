<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>
<form class="form-horizontal" id="frm-split">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.list_clean') }} ({{ $list->name }})</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group">
        <label class="col-md-3 control-label">{{ __('app.clean') }} {{ __('app.options') }} <span class="required">*</span></label>
        <div class="col-md-8">
          <div class="input-group from-group">
            <select name="options[]" id="options" class="form-control multi" multiple="multiple">
              <option value="suppressed">{{__('app.suppressed')}}</option>
              <option value="bounced">{{__('app.bounced')}}</option>
              <option value="spam">{{__('app.spam')}}</option>
              <option value="unsubscribed">{{__('app.unsubscribed')}}</option>
              <option value="inactive">{{__('app.inactive')}}</option>
              <option value="unverified">{{__('app.unverified')}}</option>
              <option value="not_confirmed">{{__('app.unconfirmed')}}</option>
            </select>
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_clean_options') }}"></i>
            </div>
          </div>
        </div>
        <span></span>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary loader" onclick="submitData(this, this.form, 'POST', '{{ route('list.clean', ['id' => $list->id]) }}', 0, 0, 0, '{{ __('app.list_clean_msg') }}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.spliting') }}">{{ __('app.clean') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>
</form>