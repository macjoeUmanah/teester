@extends('layouts.app')
@section('title', __('app.global_bounced'))

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
    "columnDefs": [{"sortable": false, "targets": [0, 6]}],
    "order": [[0, "DESC"]],
    "ajax": "{{ route('global.bounced') }}",
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});
function exportBounced(route) {
  $.get(route, function( data ) {
    toastr.success("{{ __('app.msg_export_list') }}");
  });
}
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.global_bounced') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.blacklisted') }}</li>
    <li class="active">{{ __('app.global_bounced') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div  style="float: left;">
          <div class="btn-group">
            <a href="javascript:;" onclick="viewModal('modal', '{{ route('global.bounced.import') }}')"><button class="btn btn-primary">{{ __('app.import') }}</button></a>
            <a href="javascript:;" onclick="exportBounced('{{ route('global.bounced.export') }}');"><button class="btn btn-primary">{{ __('app.export') }}</button></a>
          </div>
        </div>
        <div style="float: right;">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('global.bounced.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.email') }}</th>
          <th>{{ __('app.type') }}</th>
          <th>{{ __('app.code') }}</th>
          <th>{{ __('app.detail') }}</th>
          <th>{{ __('app.datetime') }}</th>
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
