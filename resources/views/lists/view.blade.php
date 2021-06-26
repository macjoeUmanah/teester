<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.list_detail') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.name') }}</label>
        <div class="col-md-9">{{ $list->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.group') }}</label>
        <div class="col-md-9">{{ $list->group->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.sending_server') }}</label>
        <div class="col-md-9">{{ $list->sendingServer->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.double_optin') }}</label>
        <div class="col-md-9">{{ $list->double_optin == 'Yes' ? __('app.yes') : __('app.no') }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.welcome_email') }}</label>
        <div class="col-md-9">{{ $list->welcome_email == 'Yes' ? __('app.yes') : __('app.no') }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.notification') }}</label>
        <div class="col-md-9">{{ $list->notification == 'Enabled' ? __('app.enabled') : __('app.disabled') }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.created') }}</label>
        <div class="col-md-9">{{ \Helper::datetimeDisplay($list->created_at) }}</div>
      </div>
    </div>
  </div>
  <div class="modal-header">
    <h4 class="modal-title">{{ __('app.custom_fields') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">

      <div class="form-group col-md-6"><label>{{ __('app.custom_field_name') }}</label></div>
      <div class="form-group col-md-6"><label>{{ __('app.custom_field_type') }}</label></div>
      @php ($custom_fields = $list->customFields) @endphp
      @forelse($custom_fields as $custom_field)

        <div class="form-group col-md-6">{{ $custom_field->name }}</div>
        <div class="form-group col-md-6">{{ $custom_field->type }}</div>
      @empty
        <div class="form-group col-md-12">{{ __('app.no_record_found') }}</div>
      @endforelse
    </div>
  </div>
  <div class="modal-footer">
    <a href="{{ route('list.edit', ['id' => $list->id]) }}"><button type="button" class="btn btn-primary">{{ __('app.edit') }}</button></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
  </div>
</div>