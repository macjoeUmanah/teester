@php $trigger = \App\Models\Trigger::whereId($auto_followup_stat->auto_followup_id)->withTrashed()->first(); @endphp
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ $auto_followup_stat->auto_followup_name }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="col-md-12">
        <div class="row">
          <label class="col-md-3">{{ __('app.name') }}</label>
          <div class="col-md-9">{{ $auto_followup_stat->auto_followup_name }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.schedule_by') }}</label>
          <div class="col-md-9">{{ $auto_followup_stat->schedule_by}}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.based_on') }}</label>
          <div class="col-md-9">{{ ucfirst($trigger->based_on) ?? '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.action') }}</label>
          <div class="col-md-9">{{ ucwords(str_replace('_', ' ', $trigger->action)) ?? '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.created') }}</label>
          <div class="col-md-9">{{ !empty($auto_followup_stat->created_at) ? Helper::datetimeDisplay($auto_followup_stat->created_at) : '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.lists') }}</label>
          @php $lists = \App\Models\AutoFollowupStat::statLogData($auto_followup_stat->id, 'list')->pluck('list')->toArray();@endphp
          <div class="col-md-9">{{ implode(', ', $lists) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.broadcast') }}</label>
          @php $broadcasts = \App\Models\AutoFollowupStat::statLogData($auto_followup_stat->id, 'broadcast')->pluck('broadcast')->toArray();@endphp
          <div class="col-md-9">{{ implode(', ', $broadcasts) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.setup_sending_servers') }}</label>
          @php $sending_servers = \App\Models\AutoFollowupStat::statLogData($auto_followup_stat->id, 'sending_server')->pluck('sending_server')->toArray();@endphp
          <div class="col-md-9">{{ implode(', ', $sending_servers) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.sent') }}</label>
          <div class="col-md-9">{{ $sent }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.opens') }}</label>
          <div class="col-md-9">{!! $opens !!}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.clicks') }}</label>
          <div class="col-md-9">{!! $clicks !!}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.unsubscribed') }}</label>
          <div class="col-md-9">{!! $unsubscribed !!}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.bounces') }}</label>
          <div class="col-md-9">{{ $bounces }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.spam') }}</label>
          <div class="col-md-9">{{ $spam }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>