<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">{{ $schedule_stat->schedule_campaign_name }}</h4>
  </div>
  <div class="modal-body">
    <div class="box-body">
      <div class="col-md-12">
        <div class="row">
          <label class="col-md-3">{{ __('app.schedule_campaign_name') }}</label>
          <div class="col-md-9">{{ $schedule_stat->schedule_campaign_name}}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.schedule_by') }}</label>
          <div class="col-md-9">{{ $schedule_stat->schedule_by}}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.created') }}</label>
          <div class="col-md-9">{{ !empty($schedule_stat->created_at) ? Helper::datetimeDisplay($schedule_stat->created_at) : '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.start_datetime') }}</label>
          <div class="col-md-9">{{ !empty($schedule_stat->start_datetime) ? Helper::datetimeDisplay($schedule_stat->start_datetime) : '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.end_datetime') }}</label>
          <div class="col-md-9">{{ !empty($schedule_stat->end_datetime) ? Helper::datetimeDisplay($schedule_stat->end_datetime) : '---' }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.lists') }}</label>
          @php $lists = \App\Models\ScheduleCampaignStat::statLogData($schedule_stat->id, 'list')->pluck('list')->toArray();@endphp
          <div class="col-md-9">{{ implode(', ', $lists) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.broadcast') }}</label>
          @php $broadcasts = \App\Models\ScheduleCampaignStat::statLogData($schedule_stat->id, 'broadcast')->pluck('broadcast')->toArray();@endphp
          <div class="col-md-9">{{ implode(', ', $broadcasts) }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.setup_sending_servers') }}</label>
          @php $sending_servers = \App\Models\ScheduleCampaignStat::statLogData($schedule_stat->id, 'sending_server')->pluck('total', 'sending_server')->toArray();@endphp
          <div class="col-md-9">
            @foreach($sending_servers as $sending_server => $total)
              {{$sending_server}} <strong>({{$total}})</strong>
            @endforeach
          </div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.limit') }} ({{ __('app.hourly') }})</label>
          <div class="col-md-9">{{ empty(json_decode($schedule_stat->sending_speed)->limit) ? __('app.unlimited') : json_decode($schedule_stat->sending_speed)->limit }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.total') }}</label>
          <div class="col-md-9">{{ $schedule_stat->total }}</div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.scheduled') }}</label>
          <div class="col-md-9"><a href="javascript:;" onclick="viewModal('modal', '{{ route('scheduled.detail.stat.campaign', ['id' => $schedule_stat->schedule_campaign_id]) }}')">{{ $schedule_stat->scheduled }}</a></div>
        </div>
        <div class="row">
          <label class="col-md-3">{{ __('app.sent') }}</label>
          <div class="col-md-9">{{ $schedule_stat->sent }}</div>
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
          <div class="col-md-9">{{ $unsubscribed }}</div>
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
    <a href="{{route('detail.stat.campaign', ['id' => $schedule_stat->id])}}">
      <button type="button" class="btn btn-primary">{{ __('app.detail') }}</button>
    </a>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.close') }}</button>
  </div>
</div>