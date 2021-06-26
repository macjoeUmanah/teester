@extends('layouts.app')
@section('title', $title)

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
<style>.row{height: 100% !important;}</style>
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script>detailStats('{{ $schedule_stat->id }}', 'summary');</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ $title }}
    <button style="margin-left: 20px;" class="btn btn-primary" id="stat-export" data-route="{{ route('stat.campaign.export', ['id' => $schedule_stat->id]) }}" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{ __('app.export') }}">{{ __('app.export') }}</button>
    <span id="export-download" data-route="{{ route('stat.campaign.export.download', ['id' => $schedule_stat->id]) }}" data-value="{{ __('app.download') }}"></span></h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.stats') }}</li>
    <li><a href="{{ route('stats.campaigns.index') }}">{{ __('app.campaigns') }}</a></li>
    <li class="active">{{ __('app.detail') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab_stat_campaign_summary"  onclick="detailStats('{{ $schedule_stat->id }}', 'summary');">{{ __('app.summary') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_opens" onclick="detailStats('{{ $schedule_stat->id }}', 'opens');">{{ __('app.opens') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_clicks" onclick="detailStats('{{ $schedule_stat->id }}', 'clicks');">{{ __('app.clicks') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_unsubscribed" onclick="detailStats('{{ $schedule_stat->id }}', 'unsubscribed');">{{ __('app.unsubscribed') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_bounces" onclick="detailStats('{{ $schedule_stat->id }}', 'bounces');">{{ __('app.bounces') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_spam" onclick="detailStats('{{ $schedule_stat->id }}', 'spam');">{{ __('app.spam') }}</a></li>
        <li><a data-toggle="tab" href="#tab_stat_campaign_logs" onclick="detailStats('{{ $schedule_stat->id }}', 'logs');">{{ __('app.logs') }}</a></li>
      </ul>

      <div class="tab-content" style="padding: 10px;">
        <div id="tab_stat_campaign_summary" class="tab-pane fade in active"></div>
        <div id="tab_stat_campaign_opens" class="tab-pane fade"></div>
        <div id="tab_stat_campaign_clicks" class="tab-pane fade"></div>
        <div id="tab_stat_campaign_unsubscribed" class="tab-pane fade"></div>
        <div id="tab_stat_campaign_bounces" class="tab-pane fade"></div>
        <div id="tab_stat_campaign_spam" class="tab-pane fade"></div>
        <div id="tab_stat_campaign_logs" class="tab-pane fade"></div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<!-- /.content -->
@endsection
