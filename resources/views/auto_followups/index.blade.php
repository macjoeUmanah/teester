@extends('layouts.app')
@section('title', __('app.automation_auto_followups'))

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
    "columnDefs": [{"sortable": false, "targets": [0, 5]}],
    "order": [[0, "DESC"]],
    "lengthMenu": [[15, 50], [15, 50]],
    "ajax": "{{ route('auto_followups') }}",
  });
  $("#modal").on("hidden.bs.modal", function () {
    datatable.ajax.reload(null, false); // user paging is not reset on reload
  });
});
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.automation_auto_followups') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li>{{ __('app.automation') }}</li>
    <li class="active">{{ __('app.automation_auto_followups') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin" style="z-index: 1;">
        <div  style="float: left;">
          <a href="javascript:;" onclick="viewModal('modal', '{{ route('auto_followup.create') }}')">
            <button class="btn btn-primary">{{ __('app.add_auto_followup') }}</button>
          </a>
        </div>
        <div style="float: right;">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('auto_followup.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.segment') }}</th>
          <th>{{ __('app.broadcast') }}</th>
          <th>{{ __('app.active') }}</th>
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
