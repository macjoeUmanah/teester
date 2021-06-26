@extends('layouts.app')
@section('title', __('app.roles'))

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
    "columnDefs": [{"sortable": false, "targets": [1,3]}],
    "order": [[2, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": "{{ route('getRoles') }}",
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.roles') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li class="active">{{ __('app.roles') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div  style="float: left;">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('role.create') }}')">
            <button class="btn btn-primary">{{ __('app.add_new_role') }}</button>
          </a>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.permissions') }}</th>
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
