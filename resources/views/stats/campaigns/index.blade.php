@extends('layouts.app')
@section('title', $title)

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
  $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [6,7,9]}],
    "order": [[6, "DESC"]],
    "lengthMenu": [[25, 50, 100], [25, 50, 100]],
    "ajax": {
      "url" : "{{ route('stats.campaigns') }}"
    },
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ $title }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.stats') }}</li>
    <li class="active">{{ __('app.campaigns') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th>{{ __('app.schedule_campaign_name') }}</th>
          <th>{{ __('app.schedule_by') }}</th>
          <th>{{ __('app.start_datetime') }}</th>
          <th>{{ __('app.total') }}</th>
          <th>{{ __('app.scheduled') }}</th>
          <th>{{ __('app.sent') }}</th>
          <th>{{ __('app.opens') }}</th>
          <th>{{ __('app.clicks') }}</th>
          <th>{{ __('app.created') }}</th>
          <th>{{ __('app.detail') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- /.box-body -->
  </div>
</section>
<!-- /.content -->
@endsection
