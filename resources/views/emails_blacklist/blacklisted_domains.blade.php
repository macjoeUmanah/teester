@extends('layouts.app')
@section('title', __('app.blacklisted') . ' ' . __('app.domains'))

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
    "lengthMenu": [[50, 100], [50, 100]],
    "columnDefs": [{"sortable": false, "targets": [2]}],
    "order": [[1, "DESC"]],
    "ajax": "{{ route('blacklisted.domains') }}",
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.blacklisted') }} {{ __('app.ips') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.blacklisted') }}</li>
    <li class="active">{{ __('app.domains') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th>{{ __('app.domains') }}</th>
          <th>{{ __('app.total') }}</th>
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
