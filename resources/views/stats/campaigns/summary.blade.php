<style>
  .row{
    height: 40px;
    border-bottom: 11px;
  }
</style>
<link rel="stylesheet" href="{{asset('public/components/jvectormap/jquery-jvectormap-2.0.3.css')}}">
<script src="{{asset('public/components/Chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('public/components/jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script src="{{asset('public/components/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script>
$(function () {
  'use strict';
  // Pie Chart
  $.ajax({
    url: "{{ route('campaign.sent.data', ['id' => $schedule_stat->id]) }}",
    beforeSend: function( xhr ) {  
      $('#div-chart-pie').html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
    }
  })
  .done(function( data ) {
    $('#div-chart-pie').html('<canvas id="canvas-chart-sent" style="height: 250px;"></canvas>');
    var canvas_chart_sent = $('#canvas-chart-sent').get(0).getContext('2d');
    var chart       = new Chart(canvas_chart_sent);
    var data        =  JSON.parse(data);
    var options     = {
      legend: {
        position: 'right',
        labels: {
          boxWidth: 20
        }
      },
    };

    var myPieChart = new Chart(chart, {
        type: 'pie',
        data: data,
        options: options
    });
  });

  // World Chart
  $.ajax({
    url: "{{ route('campaign.sent.data', ['id' => $schedule_stat->id, 'type' => 'country']) }}",
    beforeSend: function( xhr ) {  
      $('#world-map').html('<i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>');
    }
  })
  .done(function( data ) {
    var data = JSON.parse(data);
    // World map by jvectormap
    $('#world-map').html('');
    $('#world-map').vectorMap({
      map              : 'world_mill_en',
      backgroundColor  : 'transparent',
      regionStyle      : {
        initial: {
          fill            : '#e4e4e4',
          'fill-opacity'  : 1,
          stroke          : 'none',
          'stroke-width'  : 0,
          'stroke-opacity': 1
        },
        hover: {
          stroke: '#3D5A6B',
          "stroke-width": 2,
          cursor: 'pointer'
        }
      },
      series           : {
        regions: [
          {
            values           : data,
            scale            : ['#deeef7', '#096da5'],
            normalizeFunction: 'polynomial'
          }
        ]
      },
      onRegionTipShow: function(e, el, code){
        if (typeof data[code] != 'undefined')
          el.html(el.html() +" ({{__('app.opens')}}: "+data[code]+')');
      }
    });
  });
});
</script>
<div class="col-md-6">
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
<div class="col-md-6">
  <div class="col-md-12">
    <div class="chart">
      <div id="div-chart-pie" style="height: 250px;"></div>
    </div>
  </div>
  <div class="col-md-12">
    <div id="world-map" style="height: 280px; width: 100%; padding-top: 50px;"></div>
  </div>
</div>