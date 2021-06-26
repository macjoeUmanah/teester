@extends('layouts.app')
@section('title', __('app.view_all_scheduled_campaigns'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
  var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 2, 4, 8, 10]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": "{{ route('scheduled.campaigns') }}",
  });

  setInterval(function(){ datatable.ajax.reload(null, false); }, 20*1000); // 20 sec
});
</script>

@endsection


@section('content')
<section class="content-header">
  <h1>{{ __('app.view_all_scheduled_campaigns') }}</h1>
  {!! __('app.pasued_schedules_msg') !!}
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.schedules') }}</li>
    <li class="active">{{ __('app.schedules_campaigns') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div  style="float: left;">
          <a href="{{ route('schedule_campaign.create') }}">
            <button class="btn btn-primary">{{ __('app.schedule_new_campaign') }}</button>
          </a>
        </div>
        <div style="float: right;">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('schedule_campaign.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.schedule_campaign_name') }}</th>
          <th>{{ __('app.broadcast') }}</th>
          <th>{{ __('app.start_datetime') }}</th>
          <th>{{ __('app.limit') }} ({{ __('app.hourly') }})</th>
          <th>{{ __('app.status') }}</th>
          <th>{{ __('app.total') }}</th>
          <th>{{ __('app.scheduled') }}</th>
          <th>{{ __('app.progress') }}</th>
          <th>{{ __('app.created') }}</th>
          <th>{{ __('app.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<div id="running" data-value="{{ __('app.running')}}"></div>
<div id="running-msg" data-value="{{ __('app.msg_campaing_running')}}"></div>
<div id="paused" data-value="{{ __('app.paused')}}"></div>
<div id="paused-msg" data-value="{{ __('app.msg_campaing_paused')}}"></div>
<!-- /.content -->
@endsection
