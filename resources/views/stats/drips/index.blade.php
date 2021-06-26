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
 var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [2,4]}],
    "lengthMenu": [[25, 50, 100], [25, 50, 100]],
    "order": [[3, "DESC"]],
    "ajax": "{{ route('stats.drips') }}",
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.drips') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.stats') }}</li>
    <li class="active">{{ __('app.triggers') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  @include('includes.msgs')
  <div class="box">
    <div class="box-body">
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.group') }}</th>
          <th>{{ __('app.sent') }}</th>
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
  <input type="hidden" id="route" value="{{ route('group.delete', ['model' => 'drip']) }}">
</section>
<!-- /.content -->
@include('groups.move')
@endsection
