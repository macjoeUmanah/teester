@if($type == 'kickbox' || $type == 'emailoversight' || $type == 'neverbounce' || $type == 'sendgrid' || $type == 'mailgun' || $type == 'bulkemailchecker')
    <div class="form-group">
      <label class="col-md-3 control-label">{{ __('app.api_key') }} <span class="required">*</span></label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="api_key" value="{{ $action == 'edit' && !empty($data->api_key) ? \Crypt::decrypt($data->api_key) : '' }}" placeholder="{{ __('app.api_key') }}">
      </div>
      <span></span>
    </div>
@endif
@if($type == 'emailoversight')
    <div class="form-group">
      <label class="col-md-3 control-label">{{ __('app.list_id_emailoversite') }} <span class="required">*</span></label>
      <div class="col-md-8">
        <input type="text" class="form-control" name="list_id" value="{{ $action == 'edit' && !empty($data->list_id) ? $data->list_id : '' }}" placeholder="{{ __('app.list_id_emailoversite') }}">
      </div>
      <span></span>
    </div>
@endif