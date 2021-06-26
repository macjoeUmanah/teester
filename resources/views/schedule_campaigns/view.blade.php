<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ __('app.scheduled') }} {{ __('app.detail') }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="col-md-12">
        <div class="row">
          <label class="col-md-3">{{ __('app.schedule_campaign_name') }}</label>
          <div class="col-md-9">{{ $scheduled->name ?? '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.schedule_by') }}</label>
          <div class="col-md-9">{{ \App\Models\User::getUserValue($scheduled->user_id, 'name') ?? '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.lists') }}</label>
          @php $lists = \App\Models\Lists::whereIn('id', explode(',', $scheduled->list_ids))->pluck('name')->toArray(); @endphp
          <div class="col-md-9">{{ implode(', ', $lists) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.broadcast') }}</label>
          @php $broadcasts = \App\Models\Broadcast::whereIn('id', explode(',', $scheduled->broadcast_id))->pluck('name')->toArray(); @endphp
          <div class="col-md-9">{{ implode(', ', $broadcasts) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.setup_sending_servers') }}</label>
          @php $sending_servers = \App\Models\SendingServer::whereIn('id', explode(',', $scheduled->sending_server_ids))->pluck('name')->toArray(); @endphp
          <div class="col-md-9">{{ implode(', ', $sending_servers) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.total') }}</label>
          <div class="col-md-9">{{ $scheduled->total }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.created') }}</label>
          <div class="col-md-9">{{ Helper::datetimeDisplay($scheduled->created_at) ?? '---' }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>