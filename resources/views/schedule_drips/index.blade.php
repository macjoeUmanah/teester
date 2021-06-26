@extends('layouts.app')
@section('title', __('app.view_all_scheduled_drips'))

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
    "ajax": "{{ route('scheduled.drips') }}",
  });

});
function play(id) {
  $.ajax({
    url: getAppURL()+'/update_schedule_drip_status/'+id,
    method: 'PUT',
    data: {status: 'Paused'},
    success: function(result) {
      $('#pause-'+id).hide();
      $('#play-'+id).show();
      $('#status-'+id).html("{{ __('app.paused') }}");
      toastr.error("{{ __('app.msg_drip_paused') }}");
    }
  });
  
}
function pause(id) {
  $.ajax({
    url: getAppURL()+'/update_schedule_drip_status/'+id,
    method: 'PUT',
    data: {status: 'Running'},
    success: function(result) {
      $('#play-'+id).hide();
      $('#pause-'+id).show();
      $('#status-'+id).html("{{ __('app.running') }}");
      toastr.success("{{ __('app.msg_drip_running') }}");
    }
  });
}
</script>
@endsection

@section('content')
<section class="content-header">
  <h1>{{ __('app.view_all_scheduled_drips') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a></li>
    <li class="active">{{ __('app.drips') }}</li>
    <li>{{ __('app.schedule_drips') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="col-md-12 add-button-margin">
        <div  style="float: left;">
          <a href="{{ route('schedule_drip.create') }}">
            <button class="btn btn-primary">{{ __('app.schedule_new_drip') }}</button>
          </a>
        </div>
        <div style="float: right;">
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ __('app.actions') }} <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="javascript:;" onclick="destroyMany('{{ route('schedule_drip.destroy', ['id' => 0]) }}')"><i class="fa fa-trash"></i>{{ __('app.delete') }}</a></li>
            </ul>
          </div>
        </div>
      </div>
      <table id="data" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th><input type="checkbox" id='checkAll' value="0"></th>
          <th>{{ __('app.name') }}</th>
          <th>{{ __('app.group') }}</th>
          <th>{{ __('app.status') }}</th>
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
