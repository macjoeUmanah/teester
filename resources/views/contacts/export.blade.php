<link rel="stylesheet" href="{{asset('public/components/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')}}">
<script src="{{asset('public/components/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('public/js/multiselect.js')}}"></script>

<form class="form-horizontal" id="frm-split">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.export') }} {{ __('app.contacts') }} ({{ $list->name }})</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
  	<div class="form-group">
        <label class="col-md-2 control-label">{{ __('app.list') }}</label>
        <div class="col-md-8">
        	<label class="form-control">{{ $list->name }}</label>
        </div>
        <span></span>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">{{ __('app.option') }} <span class="required">*</span></label>
        <div class="col-md-8">
          <div class="input-group from-group">
            <select name="options[]" id="options" class="form-control multi" multiple="multiple">
              <option value="active">{{__('app.active')}}</option>
              <option value="inactive">{{__('app.inactive')}}</option>
              <option value="confirmed">{{__('app.confirmed')}}</option>
              <option value="notconfirmed">{{__('app.unconfirmed')}}</option>
              <option value="verified">{{__('app.verified')}}</option>
              <option value="notverified">{{__('app.unverified')}}</option>
              <option value="notunsubscribed">{{__('app.subscribed')}}</option>
              <option value="unsubscribed">{{__('app.unsubscribed')}}</option>
            </select>
            <div class="input-group-addon input-group-addon-right">
              <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ __('help.list_export_action') }}"></i>
            </div>
          </div>
        </div>
        <span></span>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="list_id" value="{{$list->id}}">
    <button type="button" class="btn btn-primary loader" onclick="listExport(this.form, '{{ route('contacts.export', ['id' => $list->id]) }}', '{{__('app.msg_export_list')}}')" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.export') }}">{{ __('app.export') }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>
</form>