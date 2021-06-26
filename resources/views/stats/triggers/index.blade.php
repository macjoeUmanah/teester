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
    "columnDefs": [{"sortable": false, "targets": [3,5]}],
    "order": [[4, "DESC"]],
    "lengthMenu": [[25, 50, 100], [25, 50, 100]],
    "ajax": {
      "url" : "{{ route('stats.triggers') }}"
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
    <li class="active">{{ __('app.triggers') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.based_on') }}</th>
          <th>{{ __('app.action') }}</th>
          <th>{{ __('app.schedule_by') }}</th>
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
