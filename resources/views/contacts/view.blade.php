<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.list_detail') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.list') }}</label>
        <div class="col-md-9">{{ $contact->list->name }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.contact_email') }}</label>
        <div class="col-md-9">{{ $contact->email }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.format') }}</label>
        <div class="col-md-9">{{ $contact->format }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.active') }}</label>
        <div class="col-md-9">{{ $contact->active }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.confirmed') }}</label>
        <div class="col-md-9">{{ $contact->confirmed }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.unsubscribed') }}</label>
        <div class="col-md-9">{{ $contact->unsubscribed }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.bounced') }}</label>
        <div class="col-md-9">{{ App\Models\ScheduleCampaignStatLogBounce::whereEmail($contact->email)->exists() ? __('app.yes') : __('app.no') }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.source') }}</label>
        <div class="col-md-9">{{ ucfirst($contact->source) }}</div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-md-3">{{ __('app.created') }}</label>
        <div class="col-md-9">{{ \Helper::datetimeDisplay($contact->created_at) }}</div>
      </div>
    </div>
  </div>
  <div class="modal-header">
    <h4 class="modal-title">{{ __('app.custom_fields') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      @forelse($contact->customFields as $custom_field)
        <div class="form-group col-md-12">
          <label class="col-md-3">{{ $custom_field->name }}</label>
          <div class="col-md-9">{{ str_replace('||', ', ', $custom_field->pivot->data) }}</div>
        </div>
      @empty
          <p>{{ __('app.no_record_found') }}</p>
      @endforelse
    </div>
  </div>
  <div class="modal-footer">
    <a href="{{ route('contact.edit', ['id' => $contact->id]) }}"><button type="button" class="btn btn-primary">{{ __('app.edit') }}</button></a>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
  </div>
</div>