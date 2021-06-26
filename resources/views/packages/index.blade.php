@extends('layouts.app')
@section('title', __('app.packages'))

@section('styles')
<link rel="stylesheet" href="{{asset('public/components/datatables/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('scripts')
<script src="{{asset('public/components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/datatable.init.js')}}"></script>
<script src="{{asset('public/components/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(function () {
  'use strict';
  var datatable = $('#data').DataTable({
    "columnDefs": [{"sortable": false, "targets": [0, 2, 3, 5]}],
    "order": [[0, "desc"]],
    "lengthMenu": [[15, 50, 100], [15, 50, 100]],
    "ajax": "{{ route('packages') }}",
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.packages') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.setup') }}</li>
    <li class="active">{{ __('app.packages') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div class="left">
          <div class="btn-group">
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('package.create') }}')">
              <button class="btn btn-primary">{{ __('app.add_new_package') }}</button>
            </a>
          </div>
        </div>
        <div class="right">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('package.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.no_of_recipients') }}</th>
          <th>{{ __('app.no_of_sending_servers') }}</th>
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
<!-- /.content -->
@endsection
